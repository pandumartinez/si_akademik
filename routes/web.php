<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::prefix('login/cek')->group(function () {
    Route::post('email', 'Auth\LoginController@cekEmail')
        ->name('auth.cek.email');

    Route::post('password', 'Auth\LoginController@cekPassword')
        ->name('auth.cek.password');
});

Route::middleware('auth')->group(function () {
    Route::get('', 'HomeController@home')
        ->name('home');

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('', 'ProfileController@index')
            ->name('profile');

        Route::get('edit', 'ProfileController@edit')
            ->name('profile.edit');

        Route::patch('', 'ProfileController@update')
            ->name('profile.update');
    });

    Route::resource('nilai', 'Rapot\NilaiController')
        ->only(['index', 'store']);

    Route::resource('rapot-uts', 'Rapot\RapotUtsController')
        ->only(['index', 'store']);

    Route::resource('rapot-uas', 'Rapot\RapotUasController')
        ->only(['index', 'store']);

    Route::resource('predikat', 'Rapot\PredikatController')
        ->only(['index', 'store']);

    Route::resource('deskripsi-predikat', 'Rapot\DeskripsiPredikatController')
        ->only(['index', 'store']);

    Route::resource('absen-siswa', 'Absen\AbsenSiswaController')
        ->only(['index', 'store']);

    // Admin routes
    Route::middleware('admin')->group(function () {
        // Dashboard
        Route::get('dashboard', 'HomeController@dashboard')
            ->name('home.dashboard');

        // Periode
        Route::resource('periode','PeriodeController')
            ->only(['index','store']);

        // Pengumuman
        Route::resource('pengumuman', 'PengumumanController')
            ->only(['index', 'store']);

        Route::get('absensi-guru', 'Absen\AbsenGuruController@index')
            ->name('absensi-guru');
    });

    // Guru routes
    Route::middleware('guru')->group(function () {
        Route::resource('absen-guru', 'Absen\AbsenGuruController')
            ->only(['create', 'store']);
    });
});

// Master Data routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Master Data: Mapel
    Route::resource('master-data/mapel', 'MasterData\MapelMasterDataController')
        ->except(['create', 'show']);

    // Master Data: Guru
    Route::prefix('master-data/guru')->group(function () {
        Route::get('{id}/edit/foto', 'MasterData\GuruMasterDataController@editFoto')
            ->name('guru.edit.foto');

        Route::patch('{guru}/foto', 'MasterData\GuruMasterDataController@updateFoto')
            ->name('guru.update.foto');

        Route::post('import', 'MasterData\GuruMasterDataController@import')
            ->name('guru.import');

        Route::get('export', 'MasterData\GuruMasterDataController@export')
            ->name('guru.export');
    });

    Route::resource('master-data/guru', 'MasterData\GuruMasterDataController')
        ->except(['create']);

    // Master Data: Siswa
    Route::prefix('master-data/siswa')->group(function () {
        Route::get('{id}/edit/foto', 'MasterData\SiswaMasterDataController@editFoto')
            ->name('siswa.edit.foto');

        Route::patch('{siswa}/foto', 'MasterData\SiswaMasterDataController@updateFoto')
            ->name('siswa.update.foto');
        
        Route::post('import', 'MasterData\SiswaMasterDataController@import')
            ->name('siswa.import');

        Route::get('export', 'MasterData\SiswaMasterDataController@export')
            ->name('siswa.export');
    });

    Route::resource('master-data/siswa', 'MasterData\SiswaMasterDataController')
        ->except(['create']);

    // Master Data: Kelas
    Route::resource('master-data/kelas', 'MasterData\KelasMasterDataController')
        ->parameters(['kelas' => 'kelas'])
        ->except(['create', 'show', 'edit']);

    // Master Data: Jadwal
    Route::prefix('master-data/jadwal')->group(function () {
        Route::post('import-excel', 'MasterData\JadwalMasterDataController@importExcel')
            ->name('jadwal.import-excel');

        Route::get('export-excel', 'MasterData\JadwalMasterDataController@exportExcel')
            ->name('jadwal.export-excel');
    });

    Route::resource('master-data/jadwal', 'MasterData\JadwalMasterDataController')
        ->except(['create', 'show', 'edit']);

    // Master Data: User
    Route::resource('master-data/user', 'MasterData\UserMasterDataController')
        ->only(['index', 'store', 'destroy']);
});

// Data Trash routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Trash: Guru
    Route::prefix('trash/guru')->group(function () {
        Route::get('', 'Trash\GuruTrashController@index')
            ->name('guru.index.trash');

        Route::post('restore/{id}', 'Trash\GuruTrashController@restore')
            ->name('guru.restore');

        Route::delete('{id}', 'Trash\GuruTrashController@destroy')
            ->name('guru.destroy.permanent');
    });

    // Trash: Siswa
    Route::prefix('trash/siswa')->group(function () {
        Route::get('', 'Trash\SiswaTrashController@index')
            ->name('siswa.index.trash');

        Route::post('restore/{id}', 'Trash\SiswaTrashController@restore')
            ->name('siswa.restore');

        Route::delete('{id}', 'Trash\SiswaTrashController@destroy')
            ->name('siswa.destroy.permanent');
    });

    // Trash: User
    Route::prefix('trash/user')->group(function () {
        Route::get('', 'Trash\UserTrashController@index')
            ->name('user.index.trash');

        Route::post('restore/{id}', 'Trash\UserTrashController@restore')
            ->name('user.restore');

        Route::delete('{id}', 'Trash\UserTrashController@destroy')
            ->name('user.destroy.permanent');
    });
});
