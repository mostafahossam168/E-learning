<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
        then: function () {
            Route::middleware(['web', 'check_website'])->prefix('dashboard')
                ->name('dashboard.')->group(base_path('routes/dashboard.php'));
            Route::middleware(['web', 'check_website'])->prefix('teacher/')
                ->name('teacher.')->group(base_path('routes/teacher.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check_admin' => App\Http\Middleware\CheckAdmin::class,
            'check_teacher' => App\Http\Middleware\CheckTeacher::class,
            'check_active' => App\Http\Middleware\CheckActive::class,
            'check_website' => App\Http\Middleware\CheckWebsite::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
