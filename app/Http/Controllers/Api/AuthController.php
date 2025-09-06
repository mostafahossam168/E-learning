<?php

namespace App\Http\Controllers\Api;

use App\Enums\TypeUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\Api\OtpInterface;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;
    public $itemRepository;
    public function __construct(OtpInterface $item)
    {
        $this->itemRepository = $item;
    }


    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($request->password);
        $validated['type'] = TypeUser::STUDENT;
        $user = $this->itemRepository->register($validated);
        if (! $user) {
            return $this->returnError('حدث خطاء');
        }
        $token = $user->createToken('api')->plainTextToken;
        $data = ['token' => $token, 'user' => $user];
        return $this->returnData($data, 'نم انشاء حسابك بنجاح');
    }

    public function sendOtp(Request $request)
    {
        $data = $request->validate(['phone' => 'required|string']);
        $data['code'] = rand(100000, 999999);
        $user =  $this->itemRepository->user($request->phone);;
        if (! $user) {
            return $this->returnError('الرقم غير مسجل', 404);
        }
        $this->itemRepository->sendOtp($data);
        return $this->returnSuccessMessage('تم إرسال الكود');
    }

    public function verifyOtp(Request $request)
    {
        $data =   $request->validate([
            'phone' => 'required|string',
            'code'  => 'required|string',
        ]);
        $check_code = $this->itemRepository->verifyOtp($data);
        if (! $check_code) {
            return $this->returnError('الكود غير صحيح أو منتهي', 422);
        }
        $this->itemRepository->deleteOtp($check_code->id);
        $user =  $this->itemRepository->user($request->phone);;
        $token = $user->createToken('api')->plainTextToken;
        $data = ['token' => $token, 'user' => $user];
        return $this->returnData($data, 'تم تسجيل الدخول بنجاح');
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();
        return $this->returnSuccessMessage('تم  تسجيل الخروج بنجاح');
    }
}
