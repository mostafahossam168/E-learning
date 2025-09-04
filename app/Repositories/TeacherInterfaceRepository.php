<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Interfaces\TeacherInterface;

class TeacherInterfaceRepository implements TeacherInterface
{
    public function index()
    {
        return User::teachers()->latest()->paginate(20);
    }
    public function show($id)
    {
        $item = User::find($id);
        return $item;
    }
    public function create()
    {
        return  DB::table('roles')->select('name')->get();
    }
    public function store($validated)
    {
        $user = User::create($validated);
        $user->assignRole($validated['role']);
        return $user;
    }

    public function edit($id)
    {
        $roles = DB::table('roles')->select('name')->get();
        $item = User::find($id);
        return ['roles' => $roles, 'item' => $item];
    }
    public function update($validated, $id)
    {
        $item = User::find($id);
        $item->update($validated);
        $item->syncRoles($validated['role']);
    }
    public function delete($id)
    {
        $item =  User::find($id);
        $item->delete();
    }
}
