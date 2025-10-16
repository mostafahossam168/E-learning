<?php

namespace App\Http\Controllers\Api;

use App\Enums\TypeUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\Api\ApiAuthInterface;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;
    public $itemRepository;
    public function __construct(ApiAuthInterface $item)
    {
        $this->itemRepository = $item;
    }


    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($request->password);
        $validated['type'] = TypeUser::STUDENT;
        if ($request->file('image')) {
            $validated['image'] = store_file($request->image, 'students');
        }
        $user = $this->itemRepository->register($validated);
        if (! $user) {
            return $this->returnError('حدث خطاء');
        }
        $token = $user->createToken('api')->plainTextToken;
        $data = ['token' => $token, 'user' => new UserResource($user)];
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
            'token' => 'required|string',
        ]);
        $check_code = $this->itemRepository->verifyOtp($data);
        if (! $check_code) {
            return $this->returnError('الكود غير صحيح أو منتهي', 422);
        }
        $this->itemRepository->deleteOtp($check_code->id);
        $user =  $this->itemRepository->user($request->phone);
        //Update Or create Token
        if (!$user->fcmTokens()->where('token', $request->token)->exists()) {
            $user->fcmTokens()->create(['token' => $request->token]);
        }
        $token = $user->createToken('api')->plainTextToken;
        $data = ['token' => $token, 'user' => new UserResource($user)];
        return $this->returnData($data, 'تم تسجيل الدخول بنجاح');
    }



    public function profile()
    {
        $user = $this->itemRepository->profile();
        $user = new UserResource($user);
        return $this->returnData($user);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();
        $user = $this->itemRepository->profile();
        if ($request->password) {
            $validated['password'] = bcrypt($request->password);
        }
        if ($request->file('image')) {
            //DELETE OLD IMAGE IF FOUND
            if ($user->image) {
                delete_file($user->image);
            }
            //ADD NEW IMAHE
            $validated['image'] = store_file($request->image, 'students');
        }
        $this->itemRepository->updateProfile($validated);
        return $this->returnData(new UserResource($user));
    }
    public function logout(Request $request)
    {
        $request->validate(
            [
                'token' => 'required|string'
            ]
        );
        $this->itemRepository->logout($request->token);
        return $this->returnSuccessMessage('تم  تسجيل الخروج بنجاح');
    }
}
