<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LinimasaController;
use App\Http\Controllers\TentangController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LinimasaController::class, 'index'])->name('linimasa.index');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang.index');

/*
|--------------------------------------------------------------------------
| Admin (URL sengaja disamarkan)
|--------------------------------------------------------------------------
*/
Route::prefix('admin-ca9ef168e63c4863')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');

    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
