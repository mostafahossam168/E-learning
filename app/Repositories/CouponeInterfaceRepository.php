<?php

namespace App\Repositories;

use App\Interfaces\CouponeInterface;
use App\Models\Coupone;
use App\Models\Course;

class CouponeInterfaceRepository  implements CouponeInterface
{
    public function index()
    {
        return Coupone::where(function ($q) {
            if (request('search')) {
                $q->where('code', 'LIKE', '%' . request('search') . '%');
            }
            if (request('status') && request('status') == 'yes') {
                $q->active();
            }
            if (request('status') == 'no') {
                $q->inactive();
            }
        })->latest()->paginate();
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
        return Coupone::create($validated);
    }
    public function show($id) {}
    public function edit($id)
    {
        $item = Coupone::findOrFail($id);
        $courses = Course::active()->select('id', 'title')->get();
        return [
            'item' => $item,
            'courses' => $courses,
        ];
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
}