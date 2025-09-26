<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\StudentInterface;

class StudentInterfaceRepository implements StudentInterface
{
    public function index()
    {
        $status = request('status');
        $search = request('search');
        return User::when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%");
        })->when($status, function ($q) use ($status) {
            if ($status == 'yes') {
                $q->active();
            }
            if ($status == 'no') {
                $q->inactive();
            }
        })->students()->latest()->paginate(20);
    }
    public function show($id)
    {
        $item = User::find($id);
        return $item;
    }
    public function store($validated)
    {
        $user = User::create($validated);
        return $user;
    }

    public function edit($id)
    {
        $item = User::find($id);
        return $item;
    }
    public function update($validated, $id)
    {
        $item = User::find($id);
        $item->update($validated);
    }
    public function delete($id)
    {
        $item =  User::find($id);
        $item->delete();
    }
}