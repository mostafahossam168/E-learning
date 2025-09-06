<?php

namespace App\Models;

use App\Enums\StatusLesson;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['title', 'course_id', 'video_url', 'duration', 'status'];

    public function ScopeActive($q)
    {
        return $q->where('status', 1);
    }
    public function ScopeInActive($q)
    {
        return $q->where('status', 0);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function casts(): array
    {
        return [
            'status' => StatusLesson::class
        ];
    }
}