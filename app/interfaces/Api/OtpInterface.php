<?php

namespace App\Interfaces\Api;

interface OtpInterface
{
    public function register($data);
    public function user($phone);
    public function sendOtp(array $data, int $minutes = 5);
    public function verifyOtp(array $data);
    public function deleteOtp($id);
}
