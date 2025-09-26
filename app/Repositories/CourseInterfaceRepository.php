<?php

namespace App\Repositories;

use App\Interfaces\CourseInterface;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;

class CourseInterfaceRepository implements CourseInterface
{
    public function index()
    {
        $category_id = request('category_id');
        $teacher_id = request('teacher_id');
        $status = request('status');
        $search = request('search');
        $items = Course::when($search, function ($q) use ($search) {
            $q->where('title', 'LIKE', "%$search%")
                ->orWhere('price', 'LIKE', "%$search%");
        })->when($status, function ($q) use ($status) {
            if ($status == 'yes') {
                $q->active();
            }
            if ($status == 'no') {
                $q->inactive();
            }
        })->when($category_id, function ($q) use ($category_id) {
            $q->where('category_id', $category_id);
        })->when($teacher_id, function ($q) use ($teacher_id) {
            $q->where('teacher_id', $teacher_id);
        })->latest()->paginate(30);
        return [
            'items' => $items,
            'count_all' => Course::count(),
            'count_active' => Course::active()->count(),
            'count_inactive' => Course::inactive()->count(),
        ];
    }
    public function show($id)
    {
        $item = Course::find($id);
        return $item;
    }
    public function store($validated)
    {
        return Course::create($validated);
    }
    public function edit($id)
    {
        $item = Course::find($id);
        return $item;
    }
    public function update($validated, $id)
    {
        $item = Course::find($id);
        $item->update($validated);
    }
    public function delete($id)
    {
        $item = Course::find($id);
        $item->delete();
    }



    public function getCategories()
    {
        return Category::select('id', 'name')->get();
    }
    public function getTeachers()
    {
        return User::teachers()->active()->select('id', 'name')->get();
    }
}
