@extends('dashboard.layouts.backend', ['title' => 'الكورسات'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">الكورسات</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_courses')
                        <a href="{{ route('dashboard.courses.create') }}" class="main-btn "><i class="fas fa-plus"></i> اضافة
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.courses.index') }}" class="main-btn btn-main-color">الكل :
                        {{ $count_all }}</a>
                    <a href="{{ route('dashboard.courses.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين : {{ $count_active }}</a>
                    <a href="{{ route('dashboard.courses.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير مفعلين : {{ $count_inactive }}</a>
                    <a href="{{ route('dashboard.courses.export', [
                        'category_id' => request('category_id'),
                        'status' => request('status'),
                        'search' => request('search'),
                    ]) }}"
                        class="main-btn btn-sm  bg-warning ">
                        <i class="fa-solid fa-file-excel fs-5"></i>تصدير Excel</a>
                </div>
                <form action="{{ route('dashboard.courses.index') }}" method="GET">
                    <div class="row g-3">
                        <!-- فلتر القسم -->
                        <div class="col-3">
                            <select name="category_id" class="form-select">
                                <option value="">اختيار القسم</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- فلتر الحالة -->
                        <div class="col-3">
                            <select name="status" class="form-select">
                                <option value="">اختيار الحالة</option>
                                <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>مفعل</option>
                                <option value="no" {{ request('status') == 'no' ? 'selected' : '' }}>غير مفعل
                                </option>
                            </select>
                        </div>
                        <div class="col-3">
                            <div>
                                <input class="form-control" type="search" id="" value="{{ request('search') }}"
                                    name="search" placeholder="@lang('Search')" />
                            </div>
                        </div>
                        <!-- زر البحث -->
                        <div class="col">
                            <button type="submit" class="btn btn-sm btn-primary">تصفية</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>الغلاف</th>
                        <th>القسم</th>
                        <th>المعلم</th>
                        <th>التفاصيل</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>الدروس</th>
                        <th>الاشتراكات</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> {{ $item->title }}</td>
                            <td> <img style="width: 60px; height:60px" src="{{ display_file($item->cover) }}"
                                    alt="" srcset=""></td>
                            <td> {{ $item->category->name }}</td>
                            <td> {{ $item->teacher->name }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#showDes{{ $item->id }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                @include('dashboard.courses.show-description-model', ['item' => $item])
                            </td>
                            <td> {{ $item->price }}</td>
                            <td> <span class="badge {{ $item->status->color() }}">{{ $item->status->name() }}</span> </td>
                            <td><a href="{{ route('dashboard.lessons.index', ['course_id' => $item->id]) }}"
                                    class="btn btn-sm btn-secondary"> {{ $item->lessons()->count() }}</a>
                            </td>
                            <td><a href="{{ route('dashboard.enrollments.index', ['course_id' => $item->id]) }}"
                                    class="btn btn-sm btn-warning"> {{ $item->students()->count() }}</a></td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('update_courses')
                                        <a href="{{ route('dashboard.courses.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm text-white mx-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_courses')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.courses.delete-model', ['item' => $item])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}

    </div>
@endsection
