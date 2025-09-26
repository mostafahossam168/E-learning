<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\CoursesExport;
use Illuminate\Routing\Controller;
use App\Interfaces\CourseInterface;
use App\Http\Requests\CourseRequest;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    public $itemRepository;
    public function __construct(CourseInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_courses|create_courses|update_courses|delete_courses', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_courses', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_courses', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_courses', ['only' => ['destroy']]);
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
        $categories = $this->itemRepository->getCategories();
        return view('dashboard.courses.index', compact('items', 'categories', 'count_all', 'count_active', 'count_inactive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->itemRepository->getCategories();
        $teachers = $this->itemRepository->getTeachers();
        return view('dashboard.courses.create', compact('teachers', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $data = $request->validated();
        $data['cover'] = store_file($request->cover, 'courses');
        $this->itemRepository->store($data);
        return redirect()->route('dashboard.courses.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = $this->itemRepository->getCategories();
        $teachers = $this->itemRepository->getTeachers();
        $item = $this->itemRepository->edit($id);
        return view('dashboard.courses.edit', compact('item', 'teachers', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, string $id)
    {
        $item = $this->itemRepository->show($id);
        $data = $request->validated();
        if ($request->file('cover')) {
            delete_file($item->cover);
            $data['cover'] = store_file($request->cover, 'courses');
        }
        $this->itemRepository->update($data, $id);
        return redirect()->route('dashboard.courses.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = $this->itemRepository->show($id);
        delete_file($item->cover); // DELETE COVER
        $this->itemRepository->delete($id);
        return redirect()->back()->with('success', 'تم حذف البيانات بنجاح');
    }


    public function export()
    {
        $items = $this->itemRepository->index()['items'];
        return Excel::download(new CoursesExport($items), 'courses.xlsx');
    }
}