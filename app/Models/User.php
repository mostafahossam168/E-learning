<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\StatusUser;
use App\Enums\TypeUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'status',
        'phone',
        'image'
    ];



    public function ScopeActive($q)
    {
        return $q->where('status', 1);
    }
    public function ScopeInActive($q)
    {
        return $q->where('status', 0);
    }
    public function ScopeAdmins($q)
    {
        return $q->where('type', TypeUser::ADMIN);
    }
    public function ScopeTeachers($q)
    {
        return $q->where('type', TypeUser::TEACHER);
    }
    public function ScopeStudents($q)
    {
        return $q->where('type', TypeUser::STUDENT);
    }

    public function teacherCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }


    public function studentCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id')->withPivot('status')->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(Course::class, 'favorites', 'student_id', 'course_id');
    }

    public function reviews()
    {
        return $this->belongsToMany(Course::class, 'reviews', 'student_id', 'course_id')->withPivot(['comment', 'rate', 'status'])->withTimestamps();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts()

    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => TypeUser::class,
            'status' => StatusUser::class,
        ];
    }
}