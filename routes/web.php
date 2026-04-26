<?php

use App\Http\Controllers\CafeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CafeController::class, 'index'])->name('cafe.index');
Route::resource('cafe', CafeController::class)->except(['index', 'show']);
