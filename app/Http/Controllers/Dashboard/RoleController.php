<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Requests\RoleRequest;
use App\Interfaces\RoleInterface;
use App\Repositories\RoleInterfaceRepository;
use Illuminate\Http\Request;

class RoleController extends \Illuminate\Routing\Controller
{

    public $itemRepository;
    public function __construct(RoleInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:create_roles', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_roles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_roles', ['only' => ['destroy']]);
        $this->middleware('permission:read_roles|create_roles|update_roles|delete_roles', ['only' => ['index', 'store']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->itemRepository->index();
        return view('dashboard.roles.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = config()->get('permissionsname.models');
        return view('dashboard.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $data = $request->validated();
        $this->itemRepository->store($data);
        return redirect()->route('dashboard.roles.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = $this->itemRepository->show($id)['role'];
        $permissions = $this->itemRepository->show($id)['permissions'];
        $rolePermissions = $this->itemRepository->show($id)['rolePermissions'];
        return view('dashboard.roles.show', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = $this->itemRepository->edit($id)['role'];
        $rolePermissions = $this->itemRepository->edit($id)['rolePermissions'];
        $permissions = $this->itemRepository->edit($id)['permissions'];
        return view('dashboard.roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $data = $request->validated();
        $this->itemRepository->update($data, $id);
        return redirect()->route('dashboard.roles.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->itemRepository->delete($id);
        return back()->with('success', 'تم حذف الصلاحية بنجاح ');
    }
}
