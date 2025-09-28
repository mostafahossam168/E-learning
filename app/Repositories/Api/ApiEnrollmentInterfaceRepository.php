<?php

namespace App\Repositories\Api;

use App\Interfaces\Api\ApiEnrollmentInterface;
use App\Models\Course;

class ApiEnrollmentInterfaceRepository implements ApiEnrollmentInterface
{
    public function store($course_id, $data)
    {
        $user = auth()->user();
        if ($user->studentCourses()->where('course_id', $course_id)->exists()) {
            return 0;
        }
        $user->studentCourses()->attach($course_id, $data);
        return 1;
    }


    public function index($request)
    {
        $user = auth()->user();
        return $user->studentCourses()->wherePivot('status', 1)
            ->offset($request->input('offset', 0))->take($request->input('take', 30))->get();
    }


    public function getCourse($id)
    {
        return  Course::find($id);
    }
}
