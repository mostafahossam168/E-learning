<?php

namespace App\Repositories;

use App\Models\Category;
use App\Interfaces\CategoryInterface;

class CategoryInterfaceRepository implements CategoryInterface
{
    public function index()
    {
        return Category::where(function ($q) {
            if (request('search')) {
                $q->where('name', 'LIKE', '%' . request('search') . '%');
            }
            if (request('status') && request('status') == 'yes') {
                $q->active();
            }
            if (request('status') == 'no') {
                $q->inactive();
            }
        })->latest()->paginate();
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