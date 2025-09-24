<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Interfaces\Api\FavoriteInterface;
use App\Models\Course;

class FavoriteInterfaceRepository implements FavoriteInterface
{
    public function index($request)
    {
        $user = User::with(['favorites' => function ($q) {
            $q->where('status', 1);
        }])->find(auth()->id());
        return $user->favorites()->offset($request->input('offset', 0))->take($request->input('take', 30))->get();
    }
    public function toggle($course_id)
    {
        $user = auth()->user();
        $user->favorites()->toggle($course_id);
        if ($user->favorites->contains($course_id)) {
            return 'تم اضافة الكورس للسله بنجاح';
        }
        return 'تم حذف الكورس من السله بنجاح';
    }
}