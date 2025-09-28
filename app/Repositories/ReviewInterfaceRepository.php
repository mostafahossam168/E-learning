<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ReviewInterface;

class ReviewInterfaceRepository implements ReviewInterface
{
    public function index()
    {
        $status = request('status');
        $course_id = request('course_id');
        $student_id = request('student_id');
        $items = DB::table('reviews')->when($course_id, function ($q) use ($course_id) {
            $q->where('course_id', $course_id);
        })
            ->when($student_id, function ($q) use ($student_id) {
                $q->where('student_id', $student_id);
            })
            ->when($status, function ($q) use ($status) {
                if ($status == 'yes') {
                    $q->where('status', 1);
                }
                if ($status == 'no') {
                    $q->where('status', 0);
                }
            })->latest()->paginate(30);

        $count_all = DB::table('reviews')->count();
        $count_active = DB::table('reviews')->where('status', 1)->count();
        $count_inactive = DB::table('reviews')->where('status', 0)->count();
        $students = User::students()->select('id', 'name')->get();
        $courses = Course::select('id', 'title')->get();
        return [
            'items' => $items,
            'count_all' => $count_all,
            'count_active' => $count_active,
            'count_inactive' => $count_inactive,
            'courses' => $courses,
            'students' => $students,
        ];
    }


    public function update($id, $data)
    {
        DB::table('reviews')->where('id', $id)->update(['status' => $data['status']]);
    }
}
