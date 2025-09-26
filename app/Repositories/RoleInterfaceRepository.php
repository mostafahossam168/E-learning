<?php

namespace App\Repositories;

use App\Interfaces\RoleInterface;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleInterfaceRepository implements RoleInterface
{
    public function index()
    {
        $search = request('search');
        return Role::when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE', "%$search%");
        })->orderBy('id', 'DESC')->paginate(5);
    }
    public function show($id)
    {
        $role = Role::find($id);
        $permissions = config()->get('permissionsname.models');
        $rolePermissions = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->pluck('permissions.name')
            ->all();
        return [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ];
    }
    public function store($validated)
    {
        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permission']);
        return $role;
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = config()->get('permissionsname.models');
        $rolePermissions = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', $id)
            ->pluck('permissions.name')
            ->all();
        return [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ];
    }
    public function update($validated, $id)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permission']);
        return $role;
    }
    public function delete($id)
    {
        DB::table("roles")->where('id', $id)->delete();
    }
}