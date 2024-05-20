<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
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

Route::get('/signIn', [AuthController::class, 'index'])->name('signIn.index');
Route::post('/signIn', [AuthController::class, 'authenticate'])->name('signIn.authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('signIn.logout');

Route::get('/signUp', [AuthController::class, 'signUp'])->name('signUp.index');
Route::post('/signUp', [AuthController::class, 'storeMember'])->name('signUp.storeMember');

Route::get('/adminlte', function () {
    return view('welcome_admin_lte');
});

Route::get('/template', function () {
    return view('layouts.template');
});

Route::middleware(['auth', ])->group(function () {

    Route::get('/', [WelcomeController::class, 'index'])->name('home.index');

    Route::group(['prefix' => 'member'], function(){
        Route::post('/list', [WelcomeController::class, 'list'])->name('member.list');
        Route::get('/export-pdf', [WelcomeController::class, 'exportPdf'])->name('member.export.pdf');
        Route::get('/export-excel', [WelcomeController::class, 'exportExcel'])->name('member.export.excel');
        Route::get('/updateValidation/{id}', [WelcomeController::class, 'updateValidation'])->name('member.updateValidation');
        Route::get('/{id}', [WelcomeController::class, 'show'])->name('member.show');
        Route::delete('/{id}', [WelcomeController::class, 'destroy'])->name('member.destroy');
    });
    
    Route::group(['prefix' => 'user'], function(){
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/list', [UserController::class, 'list'])->name('user.list');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/{id}', [UserController::class, 'show'])->name('user.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });
    
    Route::group(['prefix' => 'level'], function(){
        Route::get('/', [LevelController::class, 'index'])->name('level.index');
        Route::post('/list', [LevelController::class, 'list'])->name('level.list');
        Route::get('/create', [LevelController::class, 'create'])->name('level.create');
        Route::post('/', [LevelController::class, 'store'])->name('level.store');
        Route::get('/{id}', [LevelController::class, 'show'])->name('level.show');
        Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
        Route::put('/{id}', [LevelController::class, 'update'])->name('level.update');
        Route::delete('/{id}', [LevelController::class, 'destroy'])->name('level.destroy');
    });
    
    Route::group(['prefix' => 'kategori'], function(){
        Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
        Route::post('/list', [KategoriController::class, 'list'])->name('kategori.list');
        Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/{id}', [KategoriController::class, 'show'])->name('kategori.show');
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });
    
    Route::group(['prefix' => 'barang'], function(){
        Route::get('/', [BarangController::class, 'index'])->name('barang.index');
        Route::post('/list', [BarangController::class, 'list'])->name('barang.list');
        Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/{id}', [BarangController::class, 'show'])->name('barang.show');
        Route::get('/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/{id}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/{id}', [BarangController::class, 'destroy'])->name('barang.destroy'); 
    });
    
    Route::group(['prefix' => 'stok'], function(){
        Route::get('/', [StokController::class, 'index'])->name('stok.index');
        Route::get('/list', [StokController::class, 'list'])->name('stok.list');
        Route::get('/create', [StokController::class, 'create'])->name('stok.create');
        Route::post('/', [StokController::class, 'store'])->name('stok.store');
        Route::get('/{id}', [StokController::class, 'show'])->name('stok.show');
        Route::get('/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
        Route::put('/{id}', [StokController::class, 'update'])->name('stok.update');
        Route::delete('/{id}', [StokController::class, 'destroy'])->name('stok.destroy'); 
    });
    
    Route::group(['prefix' => 'penjualan'], function(){
        Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('/list', [PenjualanController::class, 'list'])->name('penjualan.list');
        Route::get('/create', [PenjualanController::class, 'create'])->name('penjualan.create');
        Route::post('/', [PenjualanController::class, 'store'])->name('penjualan.store');
        Route::get('/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
        Route::get('/{id}/edit', [PenjualanController::class, 'edit'])->name('penjualan.edit');
        Route::put('/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');
        Route::delete('/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy'); 
    });
    
    // Route::resource('m_user', POSController::class);
});


