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

    Route::get('rapot-uts/export/{kelas}', 'Rapot\RapotUtsController@export')
        ->name('rapot-uts.export');

    Route::resource('rapot-uas', 'Rapot\RapotUasController')
        ->only(['index', 'store']);

    Route::get('rapot-uas/export/{kelas}', 'Rapot\RapotUasController@export')
        ->name('rapot-uas.export');

    Route::resource('predikat', 'Rapot\PredikatController')
        ->only(['index', 'store']);

    Route::resource('deskripsi-predikat', 'Rapot\DeskripsiPredikatController')
        ->only(['index', 'store']);

    // Absen siswa
    Route::resource('absen-siswa', 'Absen\AbsenSiswaController')
        ->only(['index', 'store']);

    Route::post('absen-siswa/buka', 'Absen\AbsenSiswaController@buka')
        ->name('absen-siswa.buka');

    // Absen guru
    Route::resource('absen-guru', 'Absen\AbsenGuruController')
        ->only(['index', 'store']);

    // Admin routes
    Route::middleware('admin')->group(function () {
        // Dashboard
        Route::get('dashboard', 'HomeController@dashboard')
            ->name('home.dashboard');

        // Periode
        Route::resource('periode', 'PeriodeController')
            ->only(['index', 'store']);

        // Pengumuman
        Route::resource('pengumuman', 'PengumumanController')
            ->only(['index', 'store']);
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
        Route::post('import', 'MasterData\JadwalMasterDataController@import')
            ->name('jadwal.import');

        Route::get('export-excel', 'MasterData\JadwalMasterDataController@export')
            ->name('jadwal.export');
    });

    Route::resource('master-data/jadwal', 'MasterData\JadwalMasterDataController')
        ->except(['create', 'show', 'edit']);

    // Master Data: User
    Route::resource('master-data/user', 'MasterData\UserMasterDataController')
        ->only(['index', 'store', 'destroy']);
});
