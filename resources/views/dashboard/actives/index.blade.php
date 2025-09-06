@extends('dashboard.layouts.backend', ['title' => 'الجلسات النشطة'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>/
            <div class="large">الجلسات النشطة</div>
            @if (request('user_id'))
                /
                <div class="large">{{ \App\Models\User::find(request('user_id'))->name }}</div>
            @endif
        </div>

        {{-- <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
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

        </div> --}}
        <x-alert-component></x-alert-component>
        <div class="table-responsive">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد الالكتروني</th>
                        <th>Ip Address</th>
                        <th>الجهاز</th>
                        <th>اخر ظهور</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            @php
                                $user = App\Models\User::find($item->user_id);
                            @endphp
                            <td> {{ $user->name }}</td>
                            <td> {{ $user->email }}</td>
                            <td> {{ $item->ip_address }}</td>
                            <td> {{ $item->user_agent }}</td>
                            <td> {{ \Carbon\Carbon::createFromTimestamp($item->last_activity)->diffForHumans() }} </td>

                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('delete_actives')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.actives.delete-model', ['item' => $item])
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
