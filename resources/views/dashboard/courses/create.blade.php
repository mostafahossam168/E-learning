@extends('dashboard.layouts.backend', ['title' => 'اضافة كورس'])

@section('contant')
    <div class="main-side">


        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">الكورسات</div>/
                <div class="large">اضافة كورس جديد</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.courses.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.courses.store') }}" method="post" enctype="multipart/form-data">
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
                        القسم</label>
                    <select name="category_id" id="tax" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        المعلم</label>
                    <select name="teacher_id" id="tax" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @selected($teacher->id == old('teacher_id'))>{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span> السعر</span>
                        <div class="box-input">
                            <input type="number" name="price" value="{{ old('price') }}" id="">
                        </div>
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الحالة</label>
                    <select name="status" id="" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach (collect(\App\enums\StatusCourse::cases())->toArray() as $status)
                            <option value="{{ $status }}">
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
                            <span>الغلاف</span>
                            <div class="box-input pe-0 border-0">
                                <input type="file" name="cover" id="siteLogo" class="form-control">
                            </div>
                        </label>
                    </div>
                    @error('cover')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 ">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>تفاصيل الكورس</span>
                        </label>
                    </div>
                    <textarea name="description">{!! old('description') !!}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- 📄 عنصر Textarea لعرض المحرر -->

            <button class="d-flex justify-content-center mt-4 mx-auto" type="submit"> <a class="main-btn"> حفظ
                </a></button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <!-- ⚙️ تفعيل المحرر مع دعم اللغة العربية -->
    <script>
        CKEDITOR.replace('description', {
            language: 'ar'
        });
    </script>
@endpush
