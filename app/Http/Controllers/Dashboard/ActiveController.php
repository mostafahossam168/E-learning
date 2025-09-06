<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Interfaces\ActiveInterface;

class ActiveController extends Controller
{
    public $itemRepository;
    public function __construct(ActiveInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_admins|delete_admins', ['only' => ['index', 'destroy']]);
        $this->middleware('permission:delete_admins', ['only' => ['destroy']]);
    }
    public function index()
    {
        $items = $this->itemRepository->index();
        return view('dashboard.actives.index', compact('items'));
    }
    public function destroy($id)
    {
        $this->itemRepository->delete($id);
        return redirect()->back()->with('success', 'تم تسجبل خروج الجهاز بنجاح');
    }
}
