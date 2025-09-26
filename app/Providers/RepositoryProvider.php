<?php

namespace App\Providers;

use App\Interfaces\ActiveInterface;
use App\Interfaces\AdminInterface;
use App\Interfaces\Api\ApiAuthInterface;
use App\Interfaces\Api\ApiCourseInterface;
use App\Interfaces\Api\ApiEnrollmentInterface;
use App\Interfaces\Api\ApiReviewInterface;
use App\Interfaces\Api\FavoriteInterface;
use App\Interfaces\Api\OtpInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ContactInterface;
use App\Interfaces\CouponeInterface;
use App\Interfaces\CourseInterface;
use App\Interfaces\EnrollmentInterface;
use App\Interfaces\LessonInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\StudentInterface;
use App\Interfaces\TeacherInterface;
use App\Repositories\ActiveInterfaceRepository;
use App\Repositories\AdminInterfaceRepository;
use App\Repositories\Api\ApiAuthInterfaceRepository;
use App\Repositories\Api\ApiCourseInterfaceRepository;
use App\Repositories\Api\ApiEnrollmentInterfaceRepository;
use App\Repositories\Api\ApiReviewInterfaceRepository;
use App\Repositories\Api\FavoriteInterfaceRepository;
use App\Repositories\Api\OtpInterfaceRepository;
use App\Repositories\CategoryInterfaceRepository;
use App\Repositories\ContactInterfaceRepository;
use App\Repositories\CouponeInterfaceRepository;
use App\Repositories\CourseInterfaceRepository;
use App\Repositories\EnrollmentInterfaceRepository;
use App\Repositories\LessonInterfaceRepository;
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
        $this->app->bind(CategoryInterface::class, CategoryInterfaceRepository::class);
        $this->app->bind(LessonInterface::class, LessonInterfaceRepository::class);
        $this->app->bind(CourseInterface::class, CourseInterfaceRepository::class);
        $this->app->bind(ActiveInterface::class, ActiveInterfaceRepository::class);
        $this->app->bind(CouponeInterface::class, CouponeInterfaceRepository::class);
        $this->app->bind(ContactInterface::class, ContactInterfaceRepository::class);
        $this->app->bind(EnrollmentInterface::class, EnrollmentInterfaceRepository::class);
        //API
        $this->app->bind(ApiAuthInterface::class, ApiAuthInterfaceRepository::class);
        $this->app->bind(ApiCourseInterface::class, ApiCourseInterfaceRepository::class);
        $this->app->bind(ApiEnrollmentInterface::class, ApiEnrollmentInterfaceRepository::class);
        $this->app->bind(FavoriteInterface::class, FavoriteInterfaceRepository::class);
        $this->app->bind(ApiReviewInterface::class, ApiReviewInterfaceRepository::class);
    }
}