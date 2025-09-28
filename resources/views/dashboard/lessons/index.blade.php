@extends('dashboard.layouts.backend', ['title' => 'الدروس'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">الدروس</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_lessons')
                        <a href="{{ route('dashboard.lessons.create') }}" class="main-btn "><i class="fas fa-plus"></i> اضافة
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.lessons.index') }}" class="main-btn btn-main-color">الكل :
                        {{ $count_all }}</a>
                    <a href="{{ route('dashboard.lessons.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين : {{ $count_active }}</a>
                    <a href="{{ route('dashboard.lessons.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير مفعلين : {{ $count_inactive }}</a>
                    <a href="{{ route('dashboard.lessons.export', [
                        'course_id' => request('course_id'),
                        'search' => request('search'),
                        'status' => request('status'),
                    ]) }}"
                        class="main-btn btn-sm  bg-warning ">
                        <i class="fa-solid fa-file-excel fs-5"></i>تصدير Excel</a>
                </div>


                <form action="{{ route('dashboard.lessons.index') }}" method="GET">
                    <div class="row g-3">
                        <!-- فلتر القسم -->
                        <div class="col-3">
                            <select name="course_id" class="form-select">
                                <option value="">اختيار الكورس</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
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
                        <th>الكورس</th>
                        <th>الفيديو</th>
                        <th>الحالة</th>
                        <th>المده</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> {{ $item->title }}</td>
                            <td> {{ $item->course->title }}</td>
                            <td>
                                <a href="{{ display_file($item->video_url) }}" class="btn btn-info btn-sm" target="_blank">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                            <td> <span class="badge {{ $item->status->color() }}">{{ $item->status->name() }}</span> </td>
                            <td> {{ $item->duration }}</td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('update_lessons')
                                        <a href="{{ route('dashboard.lessons.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm text-white mx-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_lessons')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.lessons.delete-model', ['item' => $item])
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
