<?php

namespace App\Http\Controllers\dashboard;

use App\Enums\TypeUser;
use App\Exports\AdminsExport;
use Illuminate\Http\Request;
use App\Interfaces\AdminInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends \Illuminate\Routing\Controller
{

    public $itemRepository;
    public function __construct(AdminInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_admins|create_admins|update_admins|delete_admins', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_admins', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_admins', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_admins', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->itemRepository->index();
        $items = $data['items'];
        $count_all = $data['count_all'];
        $count_active = $data['count_active'];
        $count_inactive = $data['count_inactive'];
        return view('dashboard.admins.index', compact('items', 'count_all', 'count_active', 'count_inactive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->itemRepository->getRoles();
        return view('dashboard.admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $data = $request->validated();
        // return $data;
        $data['passsword'] = bcrypt($request->password);
        $data['type'] = TypeUser::ADMIN;
        if ($request->image != null) {
            $data['image'] = store_file($request->image, 'admins');
        }
        $this->itemRepository->store($data);
        return redirect()->route('dashboard.admins.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->itemRepository->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = $this->itemRepository->edit($id);
        $roles = $this->itemRepository->getRoles();
        return view('dashboard.admins.edit', compact('item', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, string $id)
    {
        $data = $request->validated();
        if ($request->password && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        if ($request->file('image')) {
            $data['image'] = store_file($request->image, 'admins');
            delete_file($this->itemRepository->show($id)->image);
        }
        $this->itemRepository->update($data, $id);
        return redirect()->route('dashboard.admins.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = $this->itemRepository->show($id);
        if ($item->image) {
            delete_file($item->image);
        }
        $this->itemRepository->delete($id);
        return redirect()->back()->with('success', 'تم حذف البيانات بنجاح');
    }

    public function export()
    {
        $items = $this->itemRepository->index()['items'];
        return Excel::download(new AdminsExport($items), 'admins.xlsx');
    }
}