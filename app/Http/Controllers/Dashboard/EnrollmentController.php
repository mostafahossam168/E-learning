<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\EnrollmentsExport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Interfaces\EnrollmentInterface;

class EnrollmentController extends Controller
{
    public $itemRepository;
    public function __construct(EnrollmentInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_enrollments|update_enrollments', ['only' => ['index', 'update']]);
    }

    public function index()
    {
        $data = $this->itemRepository->index();
        $items = $data['items'];
        $count_all = $data['count_all'];
        $count_active = $data['count_active'];
        $count_inactive = $data['count_inactive'];
        $students = $data['students'];
        $courses = $data['courses'];
        return view(
            'dashboard.enrollments.index',
            compact('items', 'count_all', 'count_active', 'count_inactive', 'students', 'courses')
        );
    }
    public function update($id) {}
    public function export()
    {
        $items = $this->itemRepository->index()['items'];
        return Excel::download(new EnrollmentsExport($items), 'enrollments.xlsx');
    }
}