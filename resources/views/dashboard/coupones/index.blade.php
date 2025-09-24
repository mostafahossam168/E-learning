@extends('dashboard.layouts.backend', ['title' => 'العروض'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>
            <div class="large">العروض</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    @can('create_coupones')
                        <a href="{{ route('dashboard.coupones.create') }}" class="main-btn "><i class="fas fa-plus"></i> اضافة
                        </a>
                    @endcan
                    <a href="{{ route('dashboard.coupones.index') }}" class="main-btn btn-main-color">الكل :
                        {{ App\Models\Coupone::count() }}</a>
                    <a href="{{ route('dashboard.coupones.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين :
                        {{ App\Models\Coupone::active()->count() }}</a>
                    <a href="{{ route('dashboard.coupones.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير
                        مفعلين :
                        {{ App\Models\Coupone::inactive()->count() }}</a>
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
                        <th>الكود</th>
                        <th>الكورس</th>
                        <th>النوع</th>
                        <th>القيمه</th>
                        <th>اقصي استخدام</th>
                        <th>المستخدم</th>
                        <th>البدايه</th>
                        <th>النهايه</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td> {{ $item->code }}</td>
                            <td> {{ $item->course->title }}</td>
                            <td> <span
                                    class="badge {{ $item->discount_type->color() }}">{{ $item->discount_type->name() }}</span>
                            </td>
                            <td> {{ $item->discount_value }}</td>
                            <td> {{ $item->usage_limit }}</td>
                            <td> {{ $item->used_count }}</td>
                            <td>{{ date('h:ia | Y-m-d ', strtotime($item->start_date)) }}</td>
                            <td>{{ date('h:ia | Y-m-d ', strtotime($item->end_date)) }}</td>
                            <td> <span class="badge {{ $item->status->color() }}">{{ $item->status->name() }}</span> </td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('update_coupones')
                                        <a href="{{ route('dashboard.coupones.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm text-white mx-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_coupones')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.coupones.delete-model', ['item' => $item])
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
