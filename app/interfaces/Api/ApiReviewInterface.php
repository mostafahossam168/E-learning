<?php

namespace App\Interfaces\Api;

interface ApiReviewInterface
{
    public function store($data);
    public function delete($course_id);
}