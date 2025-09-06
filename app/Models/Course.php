<?php

namespace App\Models;

use App\Enums\StatusCourse;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'category_id', 'cover', 'teacher_id', 'description', 'price', 'status'];

    public function ScopeActive($q)
    {
        return $q->where('status', 1);
    }
    public function ScopeInActive($q)
    {
        return $q->where('status', 0);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function casts(): array
    {
        return [
            'status' => StatusCourse::class
        ];
    }
}