<?php

namespace App\Http\Controllers\dashboard;

use App\Enums\TypeUser;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Interfaces\StudentInterface;

class StudentController extends Controller
{


    public $itemRepository;
    public function __construct(StudentInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_students|create_students|update_students|delete_students', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_students', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_students', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_students', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->itemRepository->index();
        return view('dashboard.students.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['type'] = TypeUser::STUDENT;
        if ($request->image != null) {
            $data['image'] = store_file($request->image, 'students');
        }
        $this->itemRepository->store($data);
        return redirect()->route('dashboard.students.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item =  $this->itemRepository->edit($id);
        return view('dashboard.students.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, string $id)
    {
        $data = $request->validated();
        $item = $this->itemRepository->show($id);
        if ($request->password && !empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        //Image Exist
        if ($request->image != null) {
            if ($item->image) {
                delete_file($item->image);
            }
            $data['image'] = store_file($request->image, 'students');
        }

        $this->itemRepository->update($data, $id);
        return redirect()->route('dashboard.students.index')->with('success', 'تم حفظ البيانات بنجاح');
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