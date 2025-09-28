@extends('dashboard.layouts.backend', ['title' => 'اضافة درس'])

@section('contant')
    <div class="main-side">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">الدروس</div>/
                <div class="large">اضافة درس جديد</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.lessons.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.lessons.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>العنوان</span>
                        <div class="box-input">
                            <input type="text" name="title" value="{{ old('title') }}" id="">
                        </div>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الكورس</label>
                    <select name="course_id" id="tax" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected($course->id == old('course_id'))>{{ $course->title }}</option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الحالة</label>
                    <select name="status" id="" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach (collect(\App\enums\StatusLesson::cases())->toArray() as $status)
                            <option value="{{ $status }}" @selected(old('status') === $status->value)>
                                {{ $status->name() }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12 col-md-4 col-lg-3">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>الفيديو</span>
                            <div class="box-input pe-0 border-0">
                                <input type="file" name="video_url" id="siteLogo" class="form-control">
                            </div>
                        </label>
                    </div>
                    @error('video_url')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <button class="d-flex justify-content-center mt-4 mx-auto" type="submit"> <a class="main-btn"> حفظ
                </a></button>
        </form>
    </div>
@endsection
