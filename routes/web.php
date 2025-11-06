<?php

use App\Http\Controllers\SvgController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SvgController::class, 'index'])->name('home');
Route::get('/customize/{template}', [SvgController::class, 'customize'])->name('customize');
Route::post('/generate', [SvgController::class, 'generate'])->name('generate');
Route::get('/cleanup', [SvgController::class, 'cleanup'])->name('cleanup'); // Optional cleanup route