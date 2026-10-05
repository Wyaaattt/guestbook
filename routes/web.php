<?php

use App\Exports\KunjunganExport;
use App\Exports\KunjunganPerDepartemenExport;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\LaporanController;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::resource('FormPBT', TamuController::class);
Route::resource('Kunjungan-Tamu', KunjunganController::class);
Route::resource('Dashboard', DashboardController::class)->name('index', 'Dashboard');
Route::get('/export-kunjungan', [KunjunganController::class, 'export_kunjungan'])->name('Kunjungan-Tamu.export_kunjungan');
Route::get('/laporan/kunjungan', [LaporanController::class, 'index'])->name('laporan.kunjungan');
Route::get('/kunjungan/export/{id}', [KunjunganController::class, 'exportdepartemen'])->name('kunjungan.export');


// Route::get('/kunjungan/detail', [KunjunganController::class, 'detailPerDepartemen'])->name('kunjungan.detailPerDepartemen');
// Route::get('/kunjungan/detail/{id}', [KunjunganController::class, 'detail'])->name('kunjungan.detail');
