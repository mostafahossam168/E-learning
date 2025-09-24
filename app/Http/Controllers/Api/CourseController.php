<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ShowCourseResource;
use App\Interfaces\Api\ApiCourseInterface;

class CourseController extends Controller
{
    use ApiResponse;
    public $itemRepository;
    public function __construct(ApiCourseInterface $item)
    {
        $this->itemRepository = $item;
    }
    public function index(Request $request)
    {
        $data = $this->itemRepository->index($request);
        return $this->returnData(CourseResource::collection($data));
    }
    public function show($id)
    {
        $item = $this->itemRepository->show($id);
        if (!$item) {
            return    $this->returnError('العنصر غير موجود', 404);
        }
        return $this->returnData(new ShowCourseResource($item));
    }
}
