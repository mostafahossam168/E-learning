<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Exports\CategoriesExport;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Interfaces\CategoryInterface;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public $itemRepository;
    public function __construct(CategoryInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_categories|create_categories|update_categories|delete_categories', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_categories', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_categories', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_categories', ['only' => ['destroy']]);
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
        $categories = $data['categories'];
        return view('dashboard.categories.index', compact('items', 'count_all', 'count_active', 'count_inactive', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $this->itemRepository->store($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $data = $request->validated();
        $this->itemRepository->update($data, $id);
        return redirect()->route('dashboard.categories.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->itemRepository->delete($id);
        return redirect()->route('dashboard.categories.index')->with('success', 'تم حذف البيانات بنجاح');
    }


    public function export()
    {
        $items = $this->itemRepository->index()['items'];
        return Excel::download(new CategoriesExport($items), 'categories.xlsx');
    }
}
