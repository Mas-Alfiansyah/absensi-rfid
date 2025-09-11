<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

// SCAN
Route::get('/scan', function () {
    return view('scan.index');
});


// DATA SISWA
Route::get('/data-siswa', function () {
    return view('data-siswa.index');
});
Route::get('/tambah-data-siswa', function () {
    return view('data-siswa.tambah-data-siswa');
});
Route::get('/lihat-data-siswa', function () {
    return view('data-siswa.lihat-data-siswa');
});
Route::get('/edit-data-siswa', function () {
    return view('data-siswa.edit-data-siswa');
});


// DATA KELAS
Route::get('/data-kelas', function () {
    return view('data-kelas.index');
});
Route::get('/edit-data-kelas', function () {
    return view('data-kelas.edit-data-kelas');
});
Route::get('/tambah-data-kelas', function () {
    return view('data-kelas.tambah-data-kelas');
});

// JADWAL, ABSENSI, LAPORAN,
Route::get('/jadwal', function () {
    return view('jadwal.index');
});
Route::get('/absensi', function () {
    return view('absensi.index');
});
Route::get('/laporan', function () {
    return view('laporan.index');
});

// PENGGUNA
Route::get('/pengguna', function () {
    return view('pengguna.index');
});
Route::get('/tambah-pengguna', function () {
    return view('pengguna.tambah-pengguna');
});
Route::get('/edit-pengguna', function () {
    return view('pengguna.edit-pennguna');
});
Route::get('/lihat-pengguna', function () {
    return view('pengguna.lihat-pengguna');
});


Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});


