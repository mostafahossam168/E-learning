<?php

namespace App\Http\Controllers\Dashboard;

use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\LessonRequest;
use App\Interfaces\LessonInterface;

class LessonController extends Controller
{
    public $itemRepository;
    public function __construct(LessonInterface $item)
    {
        $this->itemRepository = $item;
        $this->middleware('permission:read_lessons|create_lessons|update_lessons|delete_lessons', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_lessons', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_lessons', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_lessons', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->itemRepository->index();
        return view('dashboard.lessons.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = $this->itemRepository->create()['courses'];
        return view('dashboard.lessons.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        $data = $request->validated();
        $data['video_url'] = store_file($request->video_url, 'lessons');
        $ffprobe = FFProbe::create();
        $duration = $ffprobe->format($request->file('video_url'))->get('duration');
        $data['duration'] = explode(".", $duration)[0];
        $this->itemRepository->store($data);
        return redirect()->route('dashboard.lessons.index')->with('success', 'تم حفظ البيانات بنجاح');
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
        $courses = $this->itemRepository->edit($id)['courses'];
        $item = $this->itemRepository->edit($id)['item'];
        return view('dashboard.lessons.edit', compact('courses', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonRequest $request, string $id)
    {
        $item = $this->itemRepository->show($id);
        $data = $request->validated();
        if ($request->file('video_url')) {
            //DELETE OLD VIDEO
            delete_file($item->video_url);
            // ADD NEW VEDIO
            $data['video_url'] = store_file($request->video_url, 'lessons');
            $ffprobe = FFProbe::create();
            $duration = $ffprobe->format($request->file('video_url'))->get('duration');
            $data['duration'] = explode(".", $duration)[0];
        }
        $this->itemRepository->update($data, $id);
        return redirect()->route('dashboard.lessons.index')->with('success', 'تم حفظ البيانات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = $this->itemRepository->show($id);
        delete_file($item->video_url); // DELETE COVER
        $this->itemRepository->delete($id);
        return redirect()->back()->with('success', 'تم حذف البيانات بنجاح');
    }
}
