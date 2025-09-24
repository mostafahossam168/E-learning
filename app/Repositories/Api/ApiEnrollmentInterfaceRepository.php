<?php

namespace App\Repositories\Api;

use App\Interfaces\Api\ApiEnrollmentInterface;

class ApiEnrollmentInterfaceRepository implements ApiEnrollmentInterface
{
    public function store($data)
    {
        $user = auth()->user();
        if ($user->studentCourses()->where('course_id', $data['course_id'])->exists()) {
            return 0;
        }
        $user->studentCourses()->attach(1);
        return 1;
    }
    public function index($request)
    {
        $user = auth()->user();
        return $user->studentCourses()->wherePivot('status', 1)
            ->offset($request->input('offset', 0))->take($request->input('take', 30))->get();
    }
}