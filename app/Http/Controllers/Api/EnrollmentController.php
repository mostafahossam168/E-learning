<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\EnrollmentResource;
use App\Interfaces\Api\ApiEnrollmentInterface;

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



    public function store(EnrollmentRequest $request)
    {
        $data = $request->validated();
        $item = $this->itemRepository->store($data);
        // return $item;
        if (!$item) {
            return $this->returnError('انت بالفعل مشترك في الكورس', 404);
        }
        return $this->returnSuccessMessage('تم الاشتراك بنجاح');
    }
}