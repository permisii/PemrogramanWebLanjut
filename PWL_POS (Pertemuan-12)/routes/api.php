<?php

use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TransaksiController;
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

// Route::post('/register', RegisterController::class)->name('register');
Route::post('/register1', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');
Route::middleware('auth:api')->get('/user', function(Request $request){
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function() {
        Route::get('/levels', [LevelController::class, 'index']);
        Route::post('/levels', [LevelController::class, 'store']);
        Route::get('/levels/{level}', [LevelController::class, 'show']);
        Route::put('/levels/{level}', [LevelController::class, 'update']);
        Route::delete('/levels/{level}', [LevelController::class, 'destroy']);
        
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);

        Route::get('/categories', [KategoriController::class, 'index']);
        Route::post('/categories', [KategoriController::class, 'store']);
        Route::get('/categories/{kategori}', [KategoriController::class, 'show']);
        Route::put('/categories/{kategori}', [KategoriController::class, 'update']);
        Route::delete('/categories/{kategori}', [KategoriController::class, 'destroy']);

        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang', [BarangController::class, 'store']);
        Route::get('/barang/{barang}', [BarangController::class, 'show']);
        Route::put('/barang/{barang}', [BarangController::class, 'update']);
        Route::delete('/barang/{barang}', [BarangController::class, 'destroy']);

        Route::get('/transaksi', [TransaksiController::class, 'index']);
        Route::post('/transaksi', [TransaksiController::class, 'store']);
        // Route::get('/transaksi/{transaksiId}', [TransaksiController::class, 'show']);
        // Route::put('/transaksi/{transaksiId}', [TransaksiController::class, 'update']);
        // Route::delete('/transaksi/{transaksiId}', [TransaksiController::class, 'destroy']);
});
