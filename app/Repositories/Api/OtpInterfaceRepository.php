<?php

namespace App\Repositories\Api;

use App\Models\Otp;
use App\Models\User;
use App\Interfaces\Api\OtpInterface;

class OtpInterfaceRepository implements OtpInterface
{
    public function register($data)
    {
        return User::create($data);
    }

    public function user($phone)
    {
        return User::students()->where('phone', $phone)->first();
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
