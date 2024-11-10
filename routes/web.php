<?php

use App\Http\Controllers\DashboardPimpinanController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\VendorPelatihanController;
use App\Http\Controllers\VendorSertifikasiController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [DashboardPimpinanController::class, 'index']);

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);
    Route::post('/list', [LevelController::class, 'list']);
    Route::get('/create', [LevelController::class, 'create']);
    Route::post('/store', [LevelController::class, 'store']);
    Route::get('/{id}/show', [LevelController::class, 'show']);
    Route::get('/{id}/edit', [LevelController::class, 'edit']);
    Route::put('/{id}update', [LevelController::class, 'update']);
    Route::get('/{id}/confirm', [LevelController::class, 'confirm']);
    Route::delete('/{id}/delete', [LevelController::class, 'delete']); 
});



//Route Mata Kuliah
Route::group(['prefix' => 'matakuliah'], function () {
    Route::get('/', [MataKuliahController::class, 'index']);
    Route::post('/list', [MataKuliahController::class, 'list']);
    Route::get('/create', [MataKuliahController::class, 'create']);
    Route::post('/store', [MataKuliahController::class, 'store']);
    Route::get('/{id}/show', [MataKuliahController::class, 'show']);
    Route::get('/{id}/edit', [MataKuliahController::class, 'edit']);
    Route::put('/{id}/update', [MataKuliahController::class, 'update']);
    Route::get('/{id}/confirm', [MataKuliahController::class, 'confirm']);
    Route::delete('/{id}/delete', [MataKuliahController::class, 'delete']);
});

//Route Vendor Pelatihan
Route::group(['prefix' => 'vendorpelatihan'], function () {
    Route::get('/', [VendorPelatihanController::class, 'index']);
    Route::post('/list', [VendorPelatihanController::class, 'list']);
    Route::get('/create', [VendorPelatihanController::class, 'create']);
    Route::post('/store', [VendorPelatihanController::class, 'store']);
    Route::get('/{id}/show', [VendorPelatihanController::class, 'show']);
    Route::get('/{id}/edit', [VendorPelatihanController::class, 'edit']);
    Route::put('/{id}/update', [VendorPelatihanController::class, 'update']);
    Route::get('/{id}/confirm', [VendorPelatihanController::class, 'confirm']);
    Route::delete('/{id}/delete', [VendorPelatihanController::class, 'delete']);
});
//Route Vendor Sertifikasi
Route::group(['prefix' => 'vendorsertifikasi'], function () {
    Route::get('/', [VendorSertifikasiController::class, 'index']);
    Route::post('/list', [VendorSertifikasiController::class, 'list']);
    Route::get('/create', [VendorSertifikasiController::class, 'create']);
    Route::post('/store', [VendorSertifikasiController::class, 'store']);
    Route::get('/{id}/show', [VendorSertifikasiController::class, 'show']);
    Route::get('/{id}/edit', [VendorSertifikasiController::class, 'edit']);
    Route::put('/{id}/update', [VendorSertifikasiController::class, 'update']);
    Route::get('/{id}/confirm', [VendorSertifikasiController::class, 'confirm']);
    Route::delete('/{id}/delete', [VendorSertifikasiController::class, 'delete']);
});
