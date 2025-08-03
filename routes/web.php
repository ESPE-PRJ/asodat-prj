<?php

use App\Http\Controllers\Pages\MembershipsController;
use App\Http\Controllers\Pages\NewsController;
use App\Http\Controllers\Pages\ServicesController;
use App\Http\Controllers\Pages\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'welcome'])->name('home');
Route::get('/servicios', [ServicesController::class, 'services'])->name('services');
Route::get('/noticias', [NewsController::class, 'news'])->name('news');
Route::get('/afiliacion', [MembershipsController::class, 'memberships'])->name('memberships');

// require __DIR__.'/settings.php';
// require __DIR__.'/auth.php';
