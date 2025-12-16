<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserLog;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            return $user->role === 'admin'
                ? redirect('/dashboard')
                : redirect('/dashboard-user');
        }

        // Jika belum login: hapus session lama dan buat token CSRF baru untuk menghindari 419
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input kosong
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.'
        ]);

        $username = $request->username;
        $password = $request->password;
        $credentials = ['username' => $username, 'password' => $password];

        // Cek apakah username ada di database
        $user = User::where('username', $username)->first();

        // Username salah (tidak ditemukan)
        if (!$user) {
            return back()->withErrors([
                'username' => 'Username dan Password Salah'
            ])->withInput();
        }

        // Jika username ditemukan tapi password salah
        if (!Auth::validate($credentials)) {
            return back()->withErrors([
                'password' => 'Password salah.'
            ])->withInput();
        }

        // Jika username & password cocok
        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent session fixation / 419 errors
            $request->session()->regenerate();

            $user = Auth::user();

            // Catat log login jika tabel user_logs ada
            if (Schema::hasTable('user_logs')) {
                UserLog::create([
                    'user_id' => $user->id,
                    'action' => 'login',
                    'description' => 'User login'
                ]);
            }

            // Arahkan sesuai role user
            return $user->role === 'admin'
                ? redirect('/dashboard')
                : redirect('/dashboard-user');
        }

        // Fallback (seharusnya jarang terjadi)
        return back()->withErrors([
            'login' => 'Username dan password salah.'
        ])->withInput();
    }

    public function refreshSession(Request $request)
    {
        if (!$request->session()->has('_token')) {
            $request->session()->invalidate();
        }

        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'ok',
            'new_token' => csrf_token(),
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Cek apakah user masih ada (tidak null)
        if ($user && Schema::hasTable('user_logs')) {
            UserLog::create([
                'user_id' => $user->id,
                'action' => 'logout',
                'description' => 'User logout'
            ]);
        }

        if ($user) {
            Auth::logout();
        }

        // Pastikan session lama dihapus dan token CSRF baru dibuat
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // AJAX endpoint: return current session status (used for client-side session timeout detection)
    public function checkSessionStatus(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['authenticated' => false], 401);
        }

        $sessionTimeoutMinutes = (int) config('session.lifetime', 10);
        $sessionTimeoutSeconds = $sessionTimeoutMinutes * 60;

        $lastActivity = Session::get('last_activity');
        $now = now()->timestamp;

        if ($lastActivity instanceof \Carbon\Carbon) {
            $lastActivity = $lastActivity->timestamp;
        } else {
            $lastActivity = is_numeric($lastActivity) ? (int)$lastActivity : null;
        }

        // === SESSION EXPIRED === //
        if ($lastActivity && ($now - $lastActivity > $sessionTimeoutSeconds)) {

            $username = Auth::user()->username ?? 'unknown';

            // Hapus session table BERDASARKAN user_id
            try {
                DB::table('sessions')->where('user_id', Auth::id())->delete();
            } catch (\Exception $e) {
                Log::error('[SessionExpired] DB delete session error: ' . $e->getMessage());
            }

            // Logout total
            Auth::logout();

            // Flush semua data session
            Session::flush();

            // Invalidate session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::warning("[SessionExpired] User $username expired after " . ($now - $lastActivity) . " seconds");

            return response()
                ->json([
                    'authenticated' => false,
                    'expired' => true,
                    'sessionTimeoutSeconds' => $sessionTimeoutSeconds
                ], 401)
                ->header('Clear-Site-Data', '"cookies", "storage"');
        }

        // === SESSION MASIH AKTIF === //
        // NOTE: Jangan update last_activity di sini! 
        // AJAX check hanya untuk monitoring, bukan user activity.
        // Hanya user interaction (klik, ketik, scroll) yang update last_activity di middleware.
        
        return response()->json([
            'authenticated' => true,
            'user' => Auth::user()->username,
            'role' => Auth::user()->role,
            'last_activity' => $lastActivity,
            'sessionTimeoutSeconds' => $sessionTimeoutSeconds,
            'sessionTimeoutMinutes' => $sessionTimeoutMinutes
        ]);
    }

    // Register user activity (mousemove/scroll/click) - update last_activity on server
    public function activity(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['authenticated' => false], 401);
        }

        // Update session last_activity
        $now = now()->timestamp;
        Session::put('last_activity', $now);

        return response()->json([
            'status' => 'ok',
            'last_activity' => $now,
            'message' => 'User activity registered'
        ]);
    }
}
