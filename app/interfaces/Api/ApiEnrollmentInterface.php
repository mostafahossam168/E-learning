<?php

namespace App\Interfaces\Api;

interface ApiEnrollmentInterface
{
    public function store($data);
    public function index($request);
}