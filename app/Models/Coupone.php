<?php

namespace App\Models;

use App\Enums\DiscountTypeCoupone;
use App\Enums\StatusCoupone;
use Illuminate\Database\Eloquent\Model;

class Coupone extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'course_id',
        'usage_limit',
        'used_count',
        'status'
    ];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function isValid($courseId)
    {
        $now = now();
        return $this->status->value === 1
            && $this->start_date <= $now
            && $this->end_date >= $now
            && $this->used_count < $this->usage_limit
            && ($this->course_id === null || $this->course_id == $courseId);
    }


    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }

    public function scopeInActive($q)
    {
        return $q->where('status', 0);
    }

    public function casts()
    {
        return [
            'status' => StatusCoupone::class,
            'discount_type' => DiscountTypeCoupone::class,
        ];
    }
}