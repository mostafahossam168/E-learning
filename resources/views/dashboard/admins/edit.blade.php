@extends('dashboard.layouts.backend', ['title' => 'تعديل مشرف'])

@section('contant')
    <div class="main-side">


        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="main-title">
                <div class="small">الرئيسية</div>/
                <div class="small">المشرفين</div>/
                <div class="large"> تعديل مشرف</div>
            </div>
            <div class="btn-holder">
                <a class="main-btn btn-main-color fs-13px" href="{{ route('dashboard.admins.index') }}">رجوع <i
                        class="fa-solid fa-arrow-left fs-13px"></i>
                </a>
            </div>
        </div>
        <x-alert-component></x-alert-component>
        <form action="{{ route('dashboard.admins.update', $item->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>الاسم</span>
                        <div class="box-input">
                            <input type="text" name="name" value="{{ $item->name }}" id="">
                        </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>البريد الالكتروني</span>
                        <div class="box-input">
                            <input type="email" name="email" value="{{ $item->email }}" id="">
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>الهاتف</span>
                        <div class="box-input">
                            <input type="text" name="phone" value="{{ $item->phone }}" id="">
                        </div>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الحالة</label>
                    <select name="status" id="tax" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach (collect(\App\Enums\StatusUser::cases())->toArray() as $status)
                            <option value="{{ $status }}" @selected($item->status == $status)>
                                {{ $status->name() }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-label" for="tax">
                        الصلاحيه</label>
                    <select name="role" id="tax" class="form-select select-setting">
                        <option value="">-- اختر --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @selected($item->roles->first()->name == $role->name)>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="inp-holder">
                        <label class="special-input">
                            <span>صورة</span>
                            <div class="box-input pe-0 border-0">
                                <input type="file" name="image" id="siteLogo" class="form-control">
                            </div>
                        </label>
                    </div>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <img style="width: 70px; height:70px" src="{{ display_file($item->image) }}" alt=""
                        srcset="">
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span>كلمة المرور</span>
                        <div class="box-input">
                            <input type="password" name="password" id="">
                        </div>
                    </label>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12 col-md-4 col-lg-3">
                    <label class="special-input">
                        <span> تاكيد كلمة المرور</span>
                        <div class="box-input">
                            <input type="password" name="password_confirmation" id="">
                        </div>
                    </label>
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button class="d-flex justify-content-center mt-4 mx-auto" type="submit"> <a class="main-btn"> حفظ
                </a></button>
        </form>
    </div>
@endsection
