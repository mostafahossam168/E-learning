<?php

use App\Http\Controllers\Dashboard\ActiveController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ContactController;
use App\Http\Controllers\Dashboard\CouponeController;
use App\Http\Controllers\Dashboard\CourseController;
use App\Http\Controllers\Dashboard\EnrollmentController;
use App\Http\Controllers\Dashboard\LessonController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::group(['middleware' => ['auth', 'check_admin', 'check_active']], function () {
    Route::view('home', 'dashboard.home')->name('home');
    Route::view('settings', 'dashboard.settings')->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->name('update-settings');
    Route::resource('admins', AdminController::class);
    Route::get('/export/admins', [AdminController::class, 'export'])->name('admins.export');
    Route::resource('students', StudentController::class);
    Route::get('/export/students', [StudentController::class, 'export'])->name('students.export');
    Route::resource('teachers', TeacherController::class);
    Route::get('/export/teachers', [TeacherController::class, 'export'])->name('teachers.export');
    Route::resource('roles', RoleController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/export/categories', [CategoryController::class, 'export'])->name('categories.export');
    Route::resource('courses', CourseController::class);
    Route::get('/export/courses', [CourseController::class, 'export'])->name('courses.export');
    Route::resource('lessons', LessonController::class);
    Route::resource('coupones', CouponeController::class);
    Route::get('/actives', [ActiveController::class, 'index'])->name('actives.index');
    Route::delete('/delete/{id}', [ActiveController::class, 'destroy'])->name('actives.destroy');
    Route::controller(ContactController::class)->prefix('contacts')->as('contacts.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/delete/{id}', 'destroy')->name('destroy');
    });
    Route::controller(EnrollmentController::class)->prefix('enrollments')->as('enrollments.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/export', 'export')->name('export');
    });
});
