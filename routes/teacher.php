<?php

use App\Http\Controllers\Dashboard\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'check_teacher', 'check_active']], function () {
    Route::get('home', function () {
        return auth()->user();
    })->name('home');
});