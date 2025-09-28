<?php

namespace App\Repositories;

use App\Interfaces\CouponeInterface;
use App\Models\Coupone;
use App\Models\Course;

class CouponeInterfaceRepository  implements CouponeInterface
{
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $discount_type = request('discount_type');
        $course_id = request('course_id');
        $start_date = request('start_date');
        $end_date = request('end_date');
        $items = Coupone::when($search, function ($q) use ($search) {
            $q->where('code', 'LIKE', "%$search%");
        })->when($status, function ($q) use ($status) {
            if ($status == 'yes') {
                $q->active();
            }
            if ($status == 'no') {
                $q->inactive();
            }
        })->when($discount_type, function ($q) use ($discount_type) {
            $q->where('discount_type', $discount_type);
        })->when($course_id, function ($q) use ($course_id) {
            if ($course_id == 'all') {
                $q->whereNull('course_id');
            }
            $q->where('course_id', $course_id)->orWhereNull('course_id');
        })->when($start_date, function ($q) use ($start_date) {
            $q->where('start_date', '>=', $start_date);
        })
            ->when($end_date, function ($q) use ($end_date) {
                $q->where('end_date', '<=', $end_date);
            })
            ->latest()->paginate(30);

        $count_all = Coupone::count();
        $count_active = Coupone::active()->count();
        $count_inactive = Coupone::inactive()->count();
        return [
            'items' => $items,
            'count_all' => $count_all,
            'count_active' => $count_active,
            'count_inactive' => $count_inactive,
        ];
    }
    public function store($validated)
    {
        return Coupone::create($validated);
    }
    public function edit($id)
    {
        $item = Coupone::findOrFail($id);
        return $item;
    }
    public function update($validated, $id)
    {
        $item = Coupone::findOrFail($id);
        $item->update($validated);
    }
    public function delete($id)
    {
        $item = Coupone::findOrFail($id);
        $item->delete();
    }

    public function getCourses()
    {
        $courses = Course::select('id', 'title')->get();
        return $courses;
    }
}
