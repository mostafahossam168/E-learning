<?php

namespace App\Interfaces\Api;

interface ApiCourseInterface
{
    public function index($request);
    public function show($id);
}
