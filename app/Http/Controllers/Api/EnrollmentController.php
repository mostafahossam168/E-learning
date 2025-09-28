<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyCouponeRequest;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\EnrollmentResource;
use App\Interfaces\Api\ApiEnrollmentInterface;
use App\Models\Coupone;
use App\Models\Course;
use App\Services\CouponService;

class EnrollmentController extends Controller
{
    use ApiResponse;
    public $itemRepository;
    public function __construct(ApiEnrollmentInterface $item)
    {
        $this->itemRepository = $item;
    }


    //Index
    public function index(Request $request)
    {
        $data = $this->itemRepository->index($request);
        $data = CourseResource::collection($data);
        return $this->returnData($data);
    }


    public function applyCoupone(ApplyCouponeRequest $request)
    {
        $course = $this->itemRepository->getCourse($request->course_id);
        $item = new CouponService();
        return $item->applyCoupon($request->code, $course, auth()->user());
    }

    public function store(EnrollmentRequest $request)
    {
        $data = $request->validated();
        $course = $this->itemRepository->getCourse($data['course_id']);
        $coupone = null;
        // تطبيق الكوبون (إذا تم تقديمه)
        if (!empty($data['code'])) {
            $couponService = new CouponService();
            $couponResponse = $couponService->applyCoupon($data['code'], $course, auth()->user());
            $responseData = $couponResponse->getData(true);
            if (!$responseData['status']) {
                return $this->returnError($responseData['message'], 404);
            }
            $finalPrice = $responseData['data']['final_price'];
            $coupone = $responseData['data']['coupone'];
        } else {
            $finalPrice = $course->price;
        }


        $data = [
            'price' => $course->price,
            'final_price' => $finalPrice,
            'coupone_id' => $coupone['id']
        ];
        // تنفيذ الاشتراك باستخدام السعر النهائي
        $item = $this->itemRepository->store($course->id, $data);
        if (!$item) {
            return $this->returnError('انت بالفعل مشترك في الكورس', 404);
        }
        if ($coupone) {
            CouponService::markAsUsed(Coupone::find($coupone['id']), auth()->user());
        }
        return $this->returnSuccessMessage('تم الاشتراك بنجاح');
    }
}
