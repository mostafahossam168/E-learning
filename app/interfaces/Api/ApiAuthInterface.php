<?php

namespace App\Interfaces\Api;

interface ApiAuthInterface
{
    public function register($data);
    public function user($phone);
    public function profile();
    public function updateProfile($data);
    public function sendOtp(array $data, int $minutes = 5);
    public function verifyOtp(array $data);
    public function deleteOtp($id);
    public function logout($token);
}
