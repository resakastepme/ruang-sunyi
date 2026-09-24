<?php

use App\Http\Controllers\LinimasaController;
use App\Http\Controllers\TentangController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LinimasaController::class, 'index'])->name('linimasa.index');
Route::get('/tentang', [TentangController::class, 'index'])->name('tentang.index');
