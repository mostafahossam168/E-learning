<?php

namespace App\Repositories\Api;

use App\Interfaces\Api\ApiReviewInterface;

class ApiReviewInterfaceRepository implements ApiReviewInterface
{
    public function store($data)
    {
        $user = auth()->user();
        if ($user->reviews()->where('course_id', $data['course_id'])->exists()) {
            $user->reviews()->updateExistingPivot($data['course_id'], $data);
        } else {
            $user->reviews()->attach($data['course_id'], $data);
        }
    }

    public function delete($course_id)
    {
        $user = auth()->user();
        if ($user->reviews()->where('course_id', $course_id)->exists()) {
            return  $user->reviews()->detach($course_id);
        }
        return 0;
    }
}