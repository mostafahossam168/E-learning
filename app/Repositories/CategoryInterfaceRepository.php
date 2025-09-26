<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\CategoryInterface;

class CategoryInterfaceRepository implements CategoryInterface
{
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $items = Category::when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE', "%$search%");
        })->when($status, function ($q) use ($status) {
            if ($status == 'yes') {
                $q->active();
            }
            if ($status == 'no') {
                $q->inactive();
            }
        })->latest()->paginate();
        $count_all = Category::count();
        $categories = Category::select('id', 'name')->get();
        $count_active = Category::active()->count();
        $count_inactive = Category::inactive()->count();
        return [
            'items' => $items,
            'count_all' => $count_all,
            'count_active' => $count_active,
            'count_inactive' => $count_inactive,
            'categories' => $categories,
        ];
    }
    public function store($validated)
    {
        Category::create($validated);
    }
    public function update($validated, $id)
    {
        $category = Category::find($id);
        $category->update($validated);
    }
    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
    }
}