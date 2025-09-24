<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\CouponeRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Interfaces\CouponeInterface;

class CouponeController extends Controller
{
    public $itemRepository;
    public function __construct(CouponeInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_coupones|create_coupones|update_coupones|delete_coupones', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_coupones', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_coupones', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_coupones', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->itemRepository->index();
        return view('dashboard.coupones.index', compact('items'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = $this->itemRepository->create();
        $courses = $items['courses'];
        return view('dashboard.coupones.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponeRequest $request)
    {
        $data = $request->validated();
        $this->itemRepository->store($data);
        return redirect()->route('dashboard.coupones.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $items = $this->itemRepository->edit($id);
        $courses = $items['courses'];
        $item = $items['item'];
        return view('dashboard.coupones.edit', compact('courses', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponeRequest $request, string $id)
    {
        $data = $request->validated();
        $this->itemRepository->update($data, $id);
        return redirect()->route('dashboard.coupones.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->itemRepository->delete($id);
        return redirect()->back()->with('success', 'تم حذف البيانات بنجاح');
    }
}