@extends('dashboard.layouts.backend', ['title' => 'الطلاب'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">الطلاب</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_students')
                        <a href="{{ route('dashboard.students.create') }}" class="main-btn "><i class="fas fa-plus"></i> اضافة
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.students.index') }}" class="main-btn btn-main-color">الكل :
                        {{ App\Models\User::students()->count() }}</a>
                    <a href="{{ route('dashboard.students.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين :
                        {{ App\Models\User::students()->active()->count() }}</a>
                    <a href="{{ route('dashboard.students.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير مفعلين :
                        {{ App\Models\User::students()->inactive()->count() }}</a>
                </div>
            </div>
            <div class="box-search">
                <form action="">
                    <img src="{{ asset('dashboard/img/icons/search.png') }}" alt="icon" />
                    <input type="search" id="" value="{{ request('search') }}" name="search"
                        placeholder="@lang('Search')" />
                </form>
            </div>

        </div>
        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الصوره</th>
                        <th>الاسم</th>
                        <th>البريد الالكتروني</th>
                        <th>الهاتف</th>
                        <th>الحالة</th>
                        <th>الكورسات</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td> <img style="width: 60px; height:60px" src="{{ display_file($item->image) }}"
                                    alt="" srcset=""></td>
                            <td> {{ $item->name }}</td>
                            <td> {{ $item->email }}</td>
                            <td> {{ $item->phone }}</td>
                            <td> <span class="badge {{ $item->status->color() }}">{{ $item->status->name() }}</span> </td>
                            <td><a href="{{ route('dashboard.enrollments.index', ['student_id' => $item->id]) }}"
                                    class="btn btn-sm btn-warning"> {{ $item->studentCourses()->count() }}</a></td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('update_students')
                                        <a href="{{ route('dashboard.students.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm text-white mx-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_students')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.students.delete-model', ['item' => $item])
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
