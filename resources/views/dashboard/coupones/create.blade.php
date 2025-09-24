@extends('dashboard.layouts.backend', ['title' => 'اضافة عرض'])

@section('contant')
    <div class="main-side">


        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">العروض</div>/
                <div class="large">اضافة عرض جديد</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.coupones.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.coupones.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>الكود</span>
                        <div class="box-input">
                            <input type="text" name="code" value="{{ old('code') }}" id="numberonly">
                        </div>
                        <span class="text-danger">الكود يجب ان يكون 6 ارقام</span>
                        @error('code')
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
                        نوع التخفيض</label>
                    <select name="discount_type" id="" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach (\App\enums\DiscountTypeCoupone::cases() as $type)
                            <option value="{{ $type }}" @selected(old('discount_type') == $type->value)>
                                {{ $type->name() }}
                            </option>
                        @endforeach
                    </select>
                    @error('discount_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>القيمه</span>
                        <div class="box-input">
                            <input type="number" step="any" min="0" name="discount_value"
                                value="{{ old('discount_value') ?? 0 }}" id="">
                        </div>
                        @error('discount_value')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>عدد مرات الاستخدام المسموحه</span>
                        <div class="box-input">
                            <input type="number" min="1" name="usage_limit" value="{{ old('usage_limit') ?? 1 }}"
                                id="">
                        </div>
                        @error('usage_limit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>البدايه</span>
                        <div class="box-input">
                            <input type="datetime-local" min="1" name="start_date" value="{{ old('start_date') }}"
                                id="">
                        </div>
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>النهايه</span>
                        <div class="box-input">
                            <input type="datetime-local" min="1" name="end_date" value="{{ old('end_date') }}"
                                id="">
                        </div>
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الحالة</label>
                    <select name="status" id="" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach (\App\enums\StatusCoupone::cases() as $status)
                            <option value="{{ $status }}" @selected(old('status') == $status->value)>
                                {{ $status->name() }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <button class="d-flex justify-content-center mt-4 mx-auto" type="submit"> <a class="main-btn"> حفظ
                </a></button>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        document.querySelector("#numberonly").addEventListener("keypress", function(evt) {
            if (evt.which < 48 || evt.which > 57) {
                evt.preventDefault();
            }
        });
        var phone = document.getElementById('numberonly'),
            cleanPhoneNumber;

        cleanPhoneNumber = function(e) {
            e.preventDefault();
            var pastedText = '';
            if (window.clipboardData && window.clipboardData.getData) { // IE
                pastedText = window.clipboardData.getData('Text');
            } else if (e.clipboardData && e.clipboardData.getData) {
                pastedText = e.clipboardData.getData('text/plain');
            }
            this.value = pastedText.replace(/\D/g, '');
        };

        phone.onpaste = cleanPhoneNumber;
    </script>
@endpush
