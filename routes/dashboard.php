<?php

use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\dashboard\RoleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\dashboard\StudentController;
use App\Http\Controllers\dashboard\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login-request');

Route::group(['middleware' => ['auth', 'check_admin', 'check_active']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::view('home', 'dashboard.home')->name('home');
    Route::view('settings', 'dashboard.settings')->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->name('update-settings');
    Route::resource('admins', AdminController::class);
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('roles', RoleController::class);
});