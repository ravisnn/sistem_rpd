<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KertasKerjaController;
use App\Http\Controllers\RencanaKegiatanController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardUserController;

// Route utama ke login
Route::get('/', function() { return redirect('/login'); });
use App\Http\Middleware\RedirectIfAuthenticatedCustom;
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware([RedirectIfAuthenticatedCustom::class, \App\Http\Middleware\NoCache::class]);
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Allow GET logout so users clicking a logout link after session expiry won't hit CSRF 419
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

// Endpoint untuk meregenerasi session + CSRF token lewat AJAX (dipanggil dari halaman login)
Route::get('/session/refresh', [AuthController::class, 'refreshSession']);

// Endpoint untuk check session status via AJAX (authenticated user only)
Route::get('/session/check-status', [AuthController::class, 'checkSessionStatus'])->middleware('auth');

// Endpoint untuk register user activity (mousemove/scroll/click) sehingga server update last_activity
Route::post('/session/activity', [AuthController::class, 'activity'])->middleware('auth');

// Dashboard admin
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', App\Http\Middleware\RedirectIfAuthenticatedCustom::class]);
// Dashboard user
Route::get('/dashboard-user', [DashboardUserController::class, 'index'])->middleware(['auth', App\Http\Middleware\RedirectIfAuthenticatedCustom::class]);

// Tambahkan keterangan username/password default:
// Admin:
//   email: admin1@email.com, password: admin123
//   email: admin2@email.com, password: admin123
// User:
//   email: user1@email.com, password: user123
//   email: user2@email.com, password: user123
// dst
// Data user bisa ditambah di tabel users (role: admin/user)

// Route Rencana Kegiatan
Route::middleware(['auth', App\Http\Middleware\RedirectIfAuthenticatedCustom::class])->group(function() {
	Route::get('/rencana-kegiatan',[RencanaKegiatanController::class,'index']);
	// JSON endpoint returning all rencana data for a year (used by client validation)
	Route::get('/rencana-kegiatan/all-data', [RencanaKegiatanController::class, 'allData']);
	Route::post('/rencana-kegiatan',[RencanaKegiatanController::class,'store']);
	Route::put('/rencana-kegiatan/{id}',[RencanaKegiatanController::class,'update']);
	Route::delete('/rencana-kegiatan/{id}',[RencanaKegiatanController::class,'destroy']);
	Route::get('/rencana-kegiatan-user', [RencanaKegiatanController::class, 'userIndex'])->name('rencana-kegiatan.user');

	// Route Realisasi
	Route::get('/realisasi',[RealisasiController::class,'index']);
	Route::post('/realisasi',[RealisasiController::class,'store']);
	Route::put('/realisasi/{id}',[RealisasiController::class,'update']);
	Route::delete('/realisasi/{id}',[RealisasiController::class,'destroy']);

	// Route Kertas Kerja
	Route::get('/kertas-kerja', [KertasKerjaController::class, 'index'])->name('kertas-kerja.index');

	// Route Monitoring RPD
	Route::get('/monitoring-rpd', [App\Http\Controllers\MonitoringRpdController::class, 'index'])->name('monitoring.rpd');

	// Route Laporan
	Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
	Route::post('/laporan/update-target', [App\Http\Controllers\LaporanController::class, 'updateTarget'])->name('laporan.updateTarget');
	Route::get('/laporan/preview-pdf', [App\Http\Controllers\LaporanPdfController::class, 'preview'])->name('laporan.previewPdf');
});