<?php

namespace App\Providers;

use App\interfaces\AdminInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\StudentInterface;
use App\Interfaces\TeacherInterface;
use App\Repositories\AdminInterfaceRepository;
use App\Repositories\RoleInterfaceRepository;
use App\Repositories\StudentInterfaceRepository;
use App\Repositories\TeacherInterfaceRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(AdminInterface::class, AdminInterfaceRepository::class);
        $this->app->bind(StudentInterface::class, StudentInterfaceRepository::class);
        $this->app->bind(TeacherInterface::class, TeacherInterfaceRepository::class);
        $this->app->bind(RoleInterface::class, RoleInterfaceRepository::class);
    }
}