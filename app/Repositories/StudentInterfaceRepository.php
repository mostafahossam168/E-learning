<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\StudentInterface;

class StudentInterfaceRepository implements StudentInterface
{
    public function index()
    {
        return User::students()->latest()->paginate(20);
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
