<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard.home');
    }
    return view('dashboard.login');
})->name('login');