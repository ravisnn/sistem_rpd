<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RedirectIfAuthenticatedCustom
{
    public function handle(Request $request, Closure $next)
    {
        // Jika sudah login, redirect dari /login ke dashboard
        if (Auth::check() && $request->is('login')) {
            if (Auth::user()->role === 'admin') {
                return redirect('/dashboard');
            } else {
                return redirect('/dashboard-user');
            }
        }

        //Pembatasan akses berdasarkan role
        if (Auth::check()) {
            // Jika role admin tapi mencoba ke dashboard-user
            if (Auth::user()->role === 'admin' && $request->is('dashboard-user') || $request->is('dashboard-user/*')) {
                return redirect('/dashboard')->with('error', 'Akses ditolak.');
            }

            // Jika role user tapi mencoba ke dashboard admin
            if (Auth::user()->role === 'user' && ($request->is('dashboard') || $request->is('dashboard/*'))) {
                return redirect('/dashboard-user')->with('error', 'Akses ditolak.');
            }
        }
        
        // Set session timeout (configurable dari SESSION_LIFETIME di .env, nilai dalam menit)
        if (Auth::check()) {
            $sessionTimeoutMinutes = (int) Config::get('session.lifetime', 10);
            $sessionTimeoutSeconds = $sessionTimeoutMinutes * 60;
            
            $lastActivity = Session::get('last_activity');
            $now = now()->timestamp;
            // Pastikan $lastActivity adalah integer
            if ($lastActivity instanceof \Carbon\Carbon) {
                $lastActivity = $lastActivity->timestamp;
            } else {
                $lastActivity = is_numeric($lastActivity) ? (int)$lastActivity : null;
            }
            
            // Check if session expired
            if ($lastActivity && ($now - $lastActivity > $sessionTimeoutSeconds)) {
                // Session expired - aggressive logout
                Auth::logout();
                Session::flush();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Also delete from database sessions table
                try {
                    DB::table('sessions')->where('id', $request->sessionId())->delete();
                } catch (\Exception $e) {
                    Log::error('[SessionExpired-Middleware] Error deleting session from DB: ' . $e->getMessage());
                }
                
                Log::warning('[SessionExpired-Middleware] Session expired for user after ' . ($now - $lastActivity) . ' seconds');
                
                // Redirect to login tanpa error message
                // SweetAlert di client akan menampilkan pesan session expired
                return redirect('/login');
            }
            
            // UPDATE last_activity HANYA untuk real user activity
            // EXCLUDE AJAX monitoring call (/session/check-status) agar tidak refresh timeout
            $isMonitoringRequest = $request->is('session/check-status') || 
                                   $request->is('session/refresh') ||
                                   ($request->isJson() && $request->path() === 'session/check-status');
            
            if (!$isMonitoringRequest) {
                // Real user activity (page load, form submit, navigation, dll)
                Session::put('last_activity', $now);
                Log::debug('[Activity] User activity recorded at ' . now()->toTimeString());
            }
        }
        return $next($request);
    }
}
