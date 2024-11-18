<?php

use App\Http\Controllers\api\BidangMinatController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\api\MataKuliahController;
use App\Http\Controllers\Api\PelatihanController;
use App\Http\Controllers\Api\SertifikasiController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('sertifikasis', [SertifikasiController::class, 'index']);
Route::post('sertifikasis', [SertifikasiController::class, 'store']);
Route::get('sertifikasis/{sertifikasi}', [SertifikasiController::class, 'show']);
Route::put('sertifikasis/{sertifikasi}', [SertifikasiController::class, 'update']);
Route::delete('sertifikasis/{sertifikasi}', [SertifikasiController::class, 'destroy']);

Route::get('pelatihans', [PelatihanController::class, 'index']);
Route::post('pelatihans', [PelatihanController::class, 'store']);
Route::get('pelatihans/{pelatihan}', [PelatihanController::class, 'show']);
Route::put('pelatihans/{pelatihan}', [PelatihanController::class, 'update']);
Route::delete('pelatihans/{pelatihan}', [PelatihanController::class, 'destroy']);

Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
Route::middleware('auth:api')->get('/user', function(Request $request){
    return $request->user();


    
});
Route::middleware(['auth:api'])->group(function () {
Route::get('levels', [LevelController::class, 'index']);
Route::post('levels', [LevelController::class, 'store']);
Route::get('levels/{level}', [LevelController::class, 'show']);
Route::put('levels/{level}', [LevelController::class, 'update']);
Route::delete('levels/{level}', [LevelController::class, 'destroy']);

Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::delete('users/{user}', [UserController::class, 'destroy']);

Route::get('bidangMinats', [BidangMinatController::class, 'index']);
Route::post('bidangMinats', [BidangMinatController::class, 'store']);
Route::get('bidangMinats/{bidangMinat}', [BidangMinatController::class, 'show']);
Route::put('bidangMinats/{bidangMinat}', [BidangMinatController::class, 'update']);
Route::delete('bidangMinats/{bidangMinat}', [BidangMinatController::class, 'destroy']);

Route::get('mataKuliahs', [MataKuliahController::class, 'index']);
Route::post('mataKuliahs', [MataKuliahController::class, 'store']);
Route::get('mataKuliahs/{mataKuliah}', [MataKuliahController::class, 'show']);
Route::put('mataKuliahs/{mataKuliah}', [MataKuliahController::class, 'update']);
Route::delete('mataKuliahs/{mataKuliah}', [MataKuliahController::class, 'destroy']);


});
