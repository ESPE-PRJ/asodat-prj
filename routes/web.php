<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Redirigir dashboard a Filament Admin
Route::get('dashboard', function () {
    return redirect('/admin');
})->middleware(['auth', 'verified'])->name('dashboard');
