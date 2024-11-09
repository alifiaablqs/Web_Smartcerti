<?php

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

Route::get('/', [WelcomeController ::class, 'index']);


use App\Http\Controllers\JenisPelatihanController;

// Route::prefix('jenis_pelatihan')->group(function () {
//     Route::get('/jenisPelatihan', [JenisPelatihanController::class, 'index'])->name('jenis_pelatihan.index');
//     Route::post('jenisPelatihan/list', [JenisPelatihanController::class, 'list'])->name('jenis_pelatihan.list');
//     Route::get('jenisPelatihan/import', [JenisPelatihanController::class, 'import'])->name('jenis_pelatihan.import');
//     Route::get('jenisPelatihan/export_pdf', [JenisPelatihanController::class, 'exportPdf'])->name('jenis_pelatihan.export_pdf');
//     Route::get('jenisPelatihan/export_excel', [JenisPelatihanController::class, 'exportExcel'])->name('jenis_pelatihan.export_excel');
//     Route::post('jenisPelatihan/create_ajax', [JenisPelatihanController::class, 'createAjax'])->name('jenis_pelatihan.create_ajax');
// });
