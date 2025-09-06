<?php

namespace App\Repositories\Api;

use App\Interfaces\Api\ApiAuthInterface;
use App\Models\Otp;
use App\Models\User;

class ApiAuthInterfaceRepository implements ApiAuthInterface
{
    public function register($data)
    {
        return User::create($data);
    }

    public function user($phone)
    {
        return User::students()->where('phone', $phone)->first();
    }

    public function profile()
    {
        return  auth('sanctum')->user();
    }

    public function updateProfile($data)
    {
        auth('sanctum')->user()->update($data);
    }

    public function sendOtp(array $data, int $minutes = 60)
    {
        return Otp::updateOrCreate(['phone' => $data['phone']], [
            'code'       => $data['code'],
            'expires_at' => now()->addMinutes($minutes),
        ]);
    }

    public function verifyOtp($data)
    {
        return Otp::where('phone', $data['phone'])
            ->where('code', $data['code'])
            ->where('expires_at', '>', now())
            ->first();
    }

    public function deleteOtp($id): void
    {
        $otp = Otp::find($id);
        $otp->delete();
    }
}
