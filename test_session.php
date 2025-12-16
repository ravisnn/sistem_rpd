<?php
/**
 * Manual test script untuk verify session timeout behavior
 * Run via: php test_session.php
 */

echo "=== Session Timeout Test ===\n\n";

// Simulate 1: Check idle detection math
$sessionTimeout = 600000; // 10 minutes in ms
$timeSinceActivity = 605000; // 10 minutes 5 seconds in ms
$isExpired = $timeSinceActivity > $sessionTimeout;

echo "Timeout (ms): $sessionTimeout\n";
echo "Time since activity (ms): $timeSinceActivity\n";
echo "Is expired (client-side calc): " . ($isExpired ? 'YES' : 'NO') . "\n\n";

// Simulate 2: Server-side check
$sessionTimeoutSec = 600; // 10 minutes
$lastActivityTs = time() - 605; // 605 seconds ago
$nowTs = time();
$idleSec = $nowTs - $lastActivityTs;
$isExpiredServer = $idleSec > $sessionTimeoutSec;

echo "Timeout (sec): $sessionTimeoutSec\n";
echo "Last activity timestamp: $lastActivityTs (was " . $idleSec . " seconds ago)\n";
echo "Now timestamp: $nowTs\n";
echo "Is expired (server-side calc): " . ($isExpiredServer ? 'YES' : 'NO') . "\n\n";

echo "✓ Test complete. Both client and server should detect expiry.\n";
