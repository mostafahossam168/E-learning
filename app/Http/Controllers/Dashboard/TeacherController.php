<?php

namespace App\Http\Controllers\dashboard;

use App\Enums\TypeUser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Interfaces\TeacherInterface;
use App\Http\Requests\TeacherRequest;
use App\Repositories\TeacherInterfaceRepository;

class TeacherController extends Controller
{

    public $itemRepository;
    public function __construct(TeacherInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_teachers|create_teachers|update_teachers|delete_teachers', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_teachers', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_teachers', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_teachers', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->itemRepository->index();
        return view('dashboard.teachers.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->itemRepository->create();
        return view('dashboard.teachers.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherRequest $request)
    {
        $data = $request->validated();
        // return $data;
        $data['passsword'] = bcrypt($request->password);
        $data['type'] = TypeUser::TEACHER;
        if ($request->image != null) {
            $data['image'] = store_file($request->image, 'teachers');
        }
        $this->itemRepository->store($data);
        return redirect()->route('dashboard.teachers.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $item = $this->itemRepository->edit($id)['item'];
        $roles = $this->itemRepository->edit($id)['roles'];

        return view('dashboard.teachers.edit', compact('item', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeacherRequest $request, string $id)
    {
        $item =  $this->itemRepository->show($id);
        $data = $request->validated();
        if ($request->password && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        if ($request->file('image')) {
            $data['image'] = store_file($request->image, 'teachers');
            if ($item->image) {
                delete_file($item->image);
            }
        }
        $this->itemRepository->update($data, $id);
        return redirect()->route('dashboard.teachers.index')->with('success', 'تم حفظ البيانات بنجاح');
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
}
