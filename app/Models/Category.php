<?php

namespace App\Models;

use App\Enums\StatusCategory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id', 'status'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    public function casts()
    {
        return [
            'status' => StatusCategory::class
        ];
    }

    public function ScopeActive($q)
    {
        return $q->where('status', 1);
    }
    public function ScopeInActive($q)
    {
        return $q->where('status', 0);
    }
}