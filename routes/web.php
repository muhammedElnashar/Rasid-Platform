<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('locale/{lang}',[\App\Http\Controllers\LocalController::class,'setLocale']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

