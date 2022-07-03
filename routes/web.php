<?php

use App\Http\Livewire\Kriteria;
use App\Http\Livewire\Alternatif;
use App\Http\Livewire\Decisioner;
use App\Http\Livewire\Perhitungan;
use App\Http\Livewire\Nilaikriteria;
use Illuminate\Support\Facades\Route;

//route halaman utama
Route::get('/', function () {
    return view('welcome');
});

//route halaman tentang
Route::get('/tentang', function () {
    return view('tentang');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    //route dashboard
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //route tambah DMs dan Alternatif
    Route::get('/tambah-pengambil-keputusan', Decisioner::class)->name('tambahdc');
    Route::get('/tambah-alternatif', Alternatif::class)->name('tambahalt');

    //route penilaian Kriteria per-user
    Route::get('/jenis-kriteria', Kriteria::class)->name('jeniskriteria');
    Route::get('/penilaian-kriteria', Nilaikriteria::class)->name('nilaikriteria');

    //route perhitungan masing-masing DMs dan Borda
    Route::get('/perhitungan', Perhitungan::class)->name('perhitungan');
});
