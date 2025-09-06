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
        return Course::where(function ($q) {
            if (request('search')) {
                $q->where('title', 'LIKE', '%' . request('search') . '%')
                    ->orWhere('price', 'LIKE', '%' . request('search') . '%');
            }
            if (request('status') && request('status') == 'yes') {
                $q->active();
            }
            if (request('status') == 'no') {
                $q->inactive();
            }
        })->latest()->paginate(30);
    }
    public function create()
    {
        $teachers = User::teachers()->active()->select('id', 'name')->get();
        $categories = Category::active()->select('id', 'name')->get();
        return [
            'teachers' => $teachers,
            'categories' => $categories,
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
        $teachers = User::teachers()->active()->select('id', 'name')->get();
        $categories = Category::active()->select('id', 'name')->get();
        $item = Course::find($id);
        return [
            'teachers' => $teachers,
            'categories' => $categories,
            'item' => $item,
        ];
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
}