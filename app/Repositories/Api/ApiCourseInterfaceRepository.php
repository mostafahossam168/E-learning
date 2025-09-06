<?php

namespace App\Repositories\Api;

use App\Interfaces\Api\ApiCourseInterface;
use App\Models\Course;

class ApiCourseInterfaceRepository implements ApiCourseInterface
{
    public function index($request)
    {
        return Course::active()->offset($request->input('offset', 0))->take($request->input('take', 30))->get();
    }
    public function show($id)
    {
        return Course::find($id);
    }
}
