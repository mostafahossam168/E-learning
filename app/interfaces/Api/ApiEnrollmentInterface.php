<?php

namespace App\Interfaces\Api;

interface ApiEnrollmentInterface
{
    public function store($course_id, $data);
    public function index($request);
    public function getCourse($id);
}
