<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Interfaces\Api\ApiReviewInterface;

class ReviewController extends Controller
{
    use ApiResponse;
    public $itemRepository;
    public function __construct(ApiReviewInterface $item)
    {
        $this->itemRepository = $item;
    }

    public function store(ReviewRequest $request)
    {
        $data = $request->validated();
        $this->itemRepository->store($data);
        return $this->returnSuccessMessage('تم الحفظ بنجاح');
    }
    public function destroy($course_id)
    {
        $item = $this->itemRepository->delete($course_id);
        if (!$item) {
            return $this->returnError('العنصر غير موجود', 404);
        }
        return $this->returnSuccessMessage('تم الحفظ بنجاح');
    }
}