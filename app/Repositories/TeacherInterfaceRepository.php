<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Interfaces\TeacherInterface;

class TeacherInterfaceRepository implements TeacherInterface
{
    public function index()
    {
        $status = request('status');
        $search = request('search');
        $items = User::when($search, function ($q) use ($search) {
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
        })->teachers()->latest()->paginate(20);

        $count_all = User::teachers()->count();
        $count_active = User::teachers()->active()->count();
        $count_inactive = User::teachers()->inactive()->count();
        return [
            'items' => $items,
            'count_all' => $count_all,
            'count_active' => $count_active,
            'count_inactive' => $count_inactive,
        ];
    }
    public function show($id)
    {
        $item = User::find($id);
        return $item;
    }
    public function store($validated)
    {
        $user = User::create($validated);
        $user->assignRole($validated['role']);
        return $user;
    }

    public function edit($id)
    {
        $item = User::find($id);
        return  $item;
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

    public function getRoles()
    {
        return  DB::table('roles')->select('name')->get();
    }
}
