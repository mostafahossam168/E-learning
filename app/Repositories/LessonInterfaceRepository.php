<?php

namespace App\Repositories;

use App\Interfaces\LessonInterface;
use App\Models\Course;
use App\Models\Lesson;

class LessonInterfaceRepository  implements LessonInterface
{
    public function index()
    {
        return Lesson::where(function ($q) {
            if (request('search')) {
                $q->where('title', 'LIKE', '%' . request('search') . '%');
            }
            if (request('status') && request('status') == 'yes') {
                $q->active();
            }
            if (request('status') == 'no') {
                $q->inactive();
            }
        })->latest()->paginate(30);
    }
    public function show($id)
    {
        $item = Lesson::find($id);
        return $item;
    }
    public function create()
    {
        $courses = Course::active()->select('id', 'title')->get();
        return [
            'courses' => $courses,
        ];
    }
    public function store($validated)
    {
        return  Lesson::create($validated);
    }
    public function edit($id)
    {
        $courses = Course::active()->select('id', 'title')->get();
        $item = Lesson::find($id);
        return [
            'courses' => $courses,
            'item' => $item,
        ];
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
}
