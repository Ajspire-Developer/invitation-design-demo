<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SvgController;

// Home – list all templates
Route::get('/', [SvgController::class, 'index'])->name('home');

// Customize – open form for selected template
Route::get('/customize/{template}', [SvgController::class, 'customize'])->name('customize');

// Generate – create the final invitation
Route::post('/generate', [SvgController::class, 'generate'])->name('generate');

// (Optional) Cleanup – delete old generated files
Route::get('/cleanup', [SvgController::class, 'cleanup'])->name('cleanup');
