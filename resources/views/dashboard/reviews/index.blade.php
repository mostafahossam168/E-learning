@extends('dashboard.layouts.backend', ['title' => 'التقيمات'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">التقيمات</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    <a href="{{ route('dashboard.reviews.index') }}" class="main-btn btn-main-color">الكل :
                        {{ $count_all }}</a>
                    <a href="{{ route('dashboard.reviews.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين : {{ $count_active }}</a>
                    <a href="{{ route('dashboard.reviews.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير مفعلين : {{ $count_inactive }}</a>
                    <a href="{{ route('dashboard.reviews.export', [
                        'course_id' => request('course_id'),
                        'student_id' => request('student_id'),
                        'status' => request('status'),
                    ]) }}"
                        class="main-btn btn-sm  bg-warning ">
                        <i class="fa-solid fa-file-excel fs-5"></i>تصدير Excel</a>
                </div>
                <form action="{{ route('dashboard.reviews.index') }}" method="GET">
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
                        <div class="col-3">
                            <select name="student_id" class="form-select">
                                <option value="">اختيار الطالب</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
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
                        <th>التاريخ</th>
                        <th>الكورس</th>
                        <th>المعلم</th>
                        <th>الطالب</th>
                        <th>التقيم</th>
                        <th>التعليق</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> {{ date('h:ia | Y-m-d ', strtotime($item->created_at)) }}</td>
                            @php
                                $course = App\Models\Course::find($item->course_id);
                            @endphp
                            <td> {{ $course->title }}</td>
                            <td> {{ $course->teacher->name }}</td>
                            @php
                                $student = App\Models\User::find($item->student_id);
                            @endphp
                            <td> {{ $student->name }}</td>
                            <td> {{ $item->rate }} </td>
                            <td> {{ $item->comment }} </td>
                            <td> <span
                                    class="badge {{ $item->status ? 'bg-success' : 'bg-danger' }}">{{ $item->status ? 'مفعل' : 'غير مفعل' }}</span>
                            </td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('update_reviews')
                                        <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.reviews.update-model', ['item' => $item])
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="5" align="center">اجمالي التقييم </td>
                        <td align="center">{{ $items->avg('rate') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        {{ $items->links() }}

    </div>
@endsection
