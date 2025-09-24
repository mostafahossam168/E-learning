<?php

namespace App\Interfaces\Api;

interface FavoriteInterface
{
    public function index($request);
    public function toggle($course_id);
}