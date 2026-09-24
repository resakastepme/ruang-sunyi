<?php

use App\Http\Controllers\LinimasaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LinimasaController::class, 'index'])->name('linimasa.index');
