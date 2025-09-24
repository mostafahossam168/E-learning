<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Interfaces\ContactInterface;

class ContactController extends Controller
{


    public $itemRepository;
    public function __construct(ContactInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_coupones', ['only' => ['index']]);
        $this->middleware('permission:delete_coupones', ['only' => ['index', 'destroy']]);
    }
    public function index()
    {
        $items = $this->itemRepository->index();
        return view('dashboard.contacts.index', compact('items'));
    }
    public function destroy($id)
    {
        $this->itemRepository->delete($id);
        return redirect()->back()->with('success', 'تم حذف البيانات بنجاح');
    }
}