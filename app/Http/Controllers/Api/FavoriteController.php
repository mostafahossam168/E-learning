<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteRequest;
use App\Http\Resources\CourseResource;
use App\Interfaces\Api\FavoriteInterface;

class FavoriteController extends Controller
{
    use ApiResponse;
    public $itemRepository;
    public function __construct(FavoriteInterface $item)
    {
        $this->itemRepository = $item;
    }

    public function index(Request $request)
    {
        $data = $this->itemRepository->index($request);
        $data = CourseResource::collection($data);
        return $this->returnData($data);
    }


    public function toggle(FavoriteRequest $request)
    {
        $message = $this->itemRepository->toggle($request->course_id);
        return $this->returnSuccessMessage($message);
    }
}