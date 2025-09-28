<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Exports\ReviewsExport;
use Illuminate\Routing\Controller;
use App\Interfaces\ReviewInterface;
use Maatwebsite\Excel\Facades\Excel;

class ReviewController extends Controller
{
    public $itemRepository;
    public function __construct(ReviewInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_reviews|update_reviews', ['only' => ['index']]);
        $this->middleware('permission:update_reviews', ['only' => ['update']]);
    }


    public function index()
    {
        $data = $this->itemRepository->index();
        $items = $data['items'];
        $items = $data['items'];
        $count_all = $data['count_all'];
        $count_active = $data['count_active'];
        $count_inactive = $data['count_inactive'];
        $students = $data['students'];
        $courses = $data['courses'];
        return view(
            'dashboard.reviews.index',
            compact('items', 'count_all', 'count_active', 'count_inactive', 'students', 'courses')
        );
    }

    public function update($id, Request $request)
    {
        $data = $request->validate(['status' => 'required|boolean']);
        $this->itemRepository->update($id, $data);
        return redirect()->back()->with('success', 'تم حفظ البيانات بنجاح');
    }
    public function export()
    {
        $items = $this->itemRepository->index()['items'];
        return Excel::download(new ReviewsExport($items), 'reviews.xlsx');
    }
}
