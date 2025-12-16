/**
 * Session Monitor - Monitor session status via AJAX and alert user when expired
 * without requiring page reload
 */

(function() {
    // Configuration (will be overridden by server response)
    let CONFIG = {
        // Check every 1 minute (60000 ms) to avoid overlapping with timeout
        checkInterval: 60000,
        warningTime: 60000,     // Show warning 1 minute before expiry (60000 ms)
        sessionTimeout: 600000  // 10 minutes default (600000 ms) - will update from server
    };

    let sessionMonitorActive = false;
    let sessionExpiredModalShown = false;
    // Prevent overlapping AJAX checks
    let isChecking = false;
    // Track last user activity timestamp (local, client-side)
    let lastUserActivity = Date.now();

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        // Only start monitoring if user is authenticated (check if page contains auth-protected content)
        if (isUserAuthenticated()) {
            // Fetch server config first, then start monitoring
            fetchServerSessionConfig().then(() => {
                startSessionMonitoring();
                setupActivityTracking();
            });
        }
    });

    // Helper: check if user appears to be authenticated
    function isUserAuthenticated() {
        // Check if CSRF token exists (only present for authenticated sessions)
        return document.querySelector('meta[name="csrf-token"]') !== null;
    }

    // Fetch session configuration from server
    async function fetchServerSessionConfig() {
        try {
            const resp = await fetch('/session/check-status', {
                method: 'GET',
                credentials: 'include',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            
            if (resp.ok) {
                const json = await resp.json();
                if (json.sessionTimeoutSeconds) {
                    // Server tells us the timeout in seconds, convert to ms
                    const newTimeout = json.sessionTimeoutSeconds * 1000;
                    CONFIG.sessionTimeout = newTimeout;
                    console.log('[SessionMonitor] Fetched server config: timeout =', json.sessionTimeoutSeconds, 'seconds =', Math.floor(newTimeout / 1000), 'sec');
                }
            }
        } catch (err) {
            console.warn('[SessionMonitor] Failed to fetch server config, using default:', err);
        }
    }

    // Setup activity tracking: update lastUserActivity on user events
    function setupActivityTracking() {
        const events = ['mousedown', 'keydown', 'scroll', 'touchstart', 'click', 'wheel'];
        let lastMouseX = null;
        let lastMouseY = null;
        let serverPingTimer = null;
        const SERVER_PING_DEBOUNCE = 3000; // send at most once every 3s

        function getCsrfToken() {
            const m = document.querySelector('meta[name="csrf-token"]');
            return m ? m.getAttribute('content') : null;
        }

        async function sendActivityPing() {
            try {
                const csrf = getCsrfToken();
                if (!csrf) return;
                
                const response = await fetch('/session/activity', {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ activity: 'user_interaction', timestamp: Date.now() })
                });
                
                if (response.ok) {
                    console.log('[SessionMonitor] Activity ping sent to server');
                } else {
                    console.warn('[SessionMonitor] Activity ping failed with status:', response.status);
                }
            } catch (err) {
                console.warn('[SessionMonitor] Failed to send activity ping:', err);
            }
        }

        document.addEventListener('mousemove', function(e) {
            // setiap pergerakan mouse dianggap aktivitas
            lastUserActivity = Date.now();
            lastMouseX = e.clientX;
            lastMouseY = e.clientY;

            // debounce server ping untuk mousemove
            if (serverPingTimer) clearTimeout(serverPingTimer);
            serverPingTimer = setTimeout(() => {
                sendActivityPing();
            }, SERVER_PING_DEBOUNCE);
        }, true);

        let debounceTimer = null;
        
        events.forEach(event => {
            document.addEventListener(event, function() {
                // Update local activity
                if (debounceTimer) clearTimeout(debounceTimer);
                lastUserActivity = Date.now();

                // Debounce server ping untuk events lainnya
                if (serverPingTimer) clearTimeout(serverPingTimer);
                serverPingTimer = setTimeout(() => {
                    sendActivityPing();
                }, SERVER_PING_DEBOUNCE);
                
                debounceTimer = setTimeout(() => {
                    console.log('[SessionMonitor] User activity detected at', new Date(lastUserActivity).toLocaleTimeString());
                }, 5000);
            }, true);  // Use capture phase to catch events early
        });
        
        console.log('[SessionMonitor] Activity tracking setup complete');
    }

    // Start the session monitoring interval
    function startSessionMonitoring() {
        if (sessionMonitorActive) return;

        sessionMonitorActive = true;
        console.log('[SessionMonitor] Started monitoring session status every', CONFIG.checkInterval / 1000, 'seconds');

        // Perform first check immediately
        checkSessionStatus();

        // Then set interval for periodic checks
        setInterval(checkSessionStatus, CONFIG.checkInterval);

        // Also check on page visibility change (resume checking when tab becomes active)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                console.log('[SessionMonitor] Page became visible, checking session status');
                checkSessionStatus();
            }
        });
    }

    // Check session status via AJAX
    function checkSessionStatus() {
        const now = Date.now();
        const timeSinceActivity = now - lastUserActivity;
        
        // Log current state for debugging
        console.log('[SessionMonitor] Check at', new Date().toLocaleTimeString(), 
                    '| Idle time:', Math.floor(timeSinceActivity / 1000), 'sec | Timeout:', Math.floor(CONFIG.sessionTimeout / 1000), 'sec');

        // First: check idle time locally
        if (timeSinceActivity > CONFIG.sessionTimeout) {
            console.warn('[SessionMonitor] User has been idle for', Math.floor(timeSinceActivity / 1000), 'seconds (> timeout of', Math.floor(CONFIG.sessionTimeout / 1000), 'sec)');
            handleSessionExpired();
            return;
        }

        // Second: verify with server
        if (isChecking) {
            // A check is already in progress; skip to avoid overlapping requests
            return;
        }
        isChecking = true;
        fetch('/session/check-status', {
            method: 'GET',
            credentials: 'include',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            // 401 means session expired on server
            if (response.status === 401) {
                console.error('[SessionMonitor] Server returned 401 (session expired)');
                handleSessionExpired();
                return null;
            }
            // 200 means session still active
            if (response.status === 200) {
                return response.json();
            }
            throw new Error('Unexpected response: ' + response.status);
        })
        .then(json => {
            if (json && json.authenticated === false) {
                // Server explicitly says session is not authenticated
                console.warn('[SessionMonitor] Server returned authenticated: false');
                handleSessionExpired();
                return;
            }
            if (json && json.authenticated) {
                // Session still active on server, reset modal flag in case it was shown
                sessionExpiredModalShown = false;
                // Update CONFIG if server sent a new timeout value
                if (json.sessionTimeoutSeconds) {
                    const newTimeout = json.sessionTimeoutSeconds * 1000;
                    if (newTimeout !== CONFIG.sessionTimeout) {
                        console.log('[SessionMonitor] Updated timeout from server:', json.sessionTimeoutSeconds, 'sec');
                        CONFIG.sessionTimeout = newTimeout;
                    }
                }
                console.log('[SessionMonitor] Server confirmed session active for user:', json.user);
            }
        })
        .catch(err => {
            console.error('[SessionMonitor] Error checking session:', err);
        })
        .finally(() => {
            isChecking = false;
        });
    }

    // Handle session expired
    function handleSessionExpired() {
        if (sessionExpiredModalShown) return;

        sessionExpiredModalShown = true;
        console.warn('[SessionMonitor] Session has expired!');

        // Show alert using SweetAlert2 if available, otherwise use native confirm
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Session Expired',
                text: 'Your session has expired. Please login again.',
                icon: 'warning',
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'Login Again',
                confirmButtonColor: '#3085d6'
            }).then(() => {
                // Clear session cookies in browser before redirecting so middleware can't reuse them
                try {
                    // Expire common Laravel cookies
                    document.cookie = 'laravel_session=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT';
                    document.cookie = 'XSRF-TOKEN=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT';

                    // Expire all cookies as a fallback
                    const cookies = document.cookie.split(';');
                    for (let i = 0; i < cookies.length; i++) {
                        const cookie = cookies[i];
                        const eqPos = cookie.indexOf('=');
                        const name = eqPos > -1 ? cookie.substr(0, eqPos).trim() : cookie.trim();
                        if (!name) continue;
                        document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT';
                    }
                    console.log('[SessionMonitor] Cleared session cookies before redirect');
                } catch (e) {
                    console.warn('[SessionMonitor] Could not clear cookies:', e);
                }
                redirectToLogin();
            });
        } else {
            // Fallback to native alert
            alert('Your session has expired. Please login again.');
            try {
                document.cookie = 'laravel_session=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT';
                document.cookie = 'XSRF-TOKEN=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT';
            } catch (e) {}
            redirectToLogin();
        }
    }

    // Redirect to login page dengan force reload
    function redirectToLogin() {
        console.log('[SessionMonitor] Redirecting to /login with hard refresh...');
        // Use replace to avoid back button returning to expired session
        // Add timestamp to force bypass browser cache
        window.location.replace('/login?expired=' + Date.now());
    }

    // Export to global scope for manual testing/debugging
    window.SessionMonitor = {
        start: startSessionMonitoring,
        stop: () => { sessionMonitorActive = false; console.log('[SessionMonitor] Monitoring stopped'); },
        check: checkSessionStatus,
        getIdleTime: () => Date.now() - lastUserActivity,
        getIdleSeconds: () => Math.floor((Date.now() - lastUserActivity) / 1000),
        getStatus: () => ({
            active: sessionMonitorActive,
            lastUserActivity: new Date(lastUserActivity).toLocaleTimeString(),
            idleSeconds: Math.floor((Date.now() - lastUserActivity) / 1000),
            timeoutSeconds: Math.floor(CONFIG.sessionTimeout / 1000),
            isExpired: (Date.now() - lastUserActivity) > CONFIG.sessionTimeout
        }),
        config: CONFIG
    };

})();
