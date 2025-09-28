<?php

namespace App\Repositories;

use App\Interfaces\LessonInterface;
use App\Models\Course;
use App\Models\Lesson;

class LessonInterfaceRepository  implements LessonInterface
{
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $items = Lesson::when($search, function ($q) use ($search) {
            $q->where('title', 'LIKE', "%$search%");
        })->when($status, function ($q) use ($status) {
            if ($status == 'yes') {
                $q->active();
            }
            if ($status == 'no') {
                $q->inactive();
            }
        })->latest()->paginate(30);

        $count_all = Lesson::count();
        $count_active = Lesson::active()->count();
        $count_inactive = Lesson::inactive()->count();
        return [
            'items' => $items,
            'count_all' => $count_all,
            'count_active' => $count_active,
            'count_inactive' => $count_inactive,
        ];
    }
    public function show($id)
    {
        $item = Lesson::find($id);
        return $item;
    }

    public function store($validated)
    {
        return  Lesson::create($validated);
    }
    public function edit($id)
    {
        $item = Lesson::find($id);
        return $item;
    }
    public function update($validated, $id)
    {
        $item = Lesson::find($id);
        $item->update($validated);
    }
    public function delete($id)
    {
        $item = Lesson::find($id);
        $item->delete();
    }
    public function getCourses()
    {
        $courses = Course::select('id', 'title')->get();
        return $courses;
    }
}
