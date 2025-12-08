<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LaporanController;

Route::get('/', fn() => redirect()->route('login'));

// hanya untuk guest
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
});

// hanya untuk user yang login
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('pengguna', PenggunaController::class);
    Route::resource('kelas', KelasController::class);

    // Transisi Tahun Ajaran (Harus sebelum resource siswas)
    Route::post('siswas/transisi', [SiswaController::class, 'transisi'])->name('siswas.transisi');
    Route::post('siswas/promote', [SiswaController::class, 'promote'])->name('siswas.promote');
    Route::resource('siswas', SiswaController::class);

    Route::resource('kelas', KelasController::class)->parameters([
        'kelas' => 'kelas'
    ]);

    // Route untuk jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');

    // Route untuk scan
    Route::get('/scan', [ScanController::class, 'index'])->name('scan.index');
    Route::post('/scan', [ScanController::class, 'submit'])->name('scan.submit');
    Route::get('/scan/list', [ScanController::class, 'list'])->name('scan.list');
    Route::post('/scan/manual', [ScanController::class, 'manual'])->name('scan.manual');
    Route::get('/scan/siswa-belum-absen', [ScanController::class, 'siswaBelumAbsen'])->name('scan.siswaBelumAbsen');

    Route::get('/scan/input-manual', [ScanController::class, 'inputManual'])->name('scan.inputManual');
    Route::post('/scan/input-manual/simpan', [ScanController::class, 'inputManualSimpan'])->name('scan.inputManual.simpan');

    // Route Absensi
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/review', [AbsensiController::class, 'review'])->name('absensi.review');
    Route::get('/absensi/export/excel', [AbsensiController::class, 'exportExcel'])->name('absensi.export.excel');
    Route::get('/absensi/export/pdf', [AbsensiController::class, 'exportPdf'])->name('absensi.export.pdf');

    Route::get('/alumni', [App\Http\Controllers\AlumniController::class, 'index'])->name('alumni.index');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/data', [LaporanController::class, 'data'])->name('laporan.data');
});
