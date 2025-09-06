<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\CourseRequest;
use App\Interfaces\CourseInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
        $items = $this->itemRepository->index();
        return view('dashboard.courses.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->itemRepository->create()['categories'];
        $teachers = $this->itemRepository->create()['teachers'];
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
        $categories = $this->itemRepository->edit($id)['categories'];
        $teachers = $this->itemRepository->edit($id)['teachers'];
        $item = $this->itemRepository->edit($id)['item'];
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
}
