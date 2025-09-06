@extends('dashboard.layouts.backend', [
    'title' => 'الاقسام',
])
@section('contant')
    <div class="main-side">
        <x-alert-component></x-alert-component>
        <div class="main-title">
            <div class="small">
                الرئيسية
            </div>/
            <div class="large">
                الاقسام
            </div>
        </div>
        <div class="bar-options d-flex align-items-center justify-content-between flex-wrap gap-1 mb-2">
            <div class="btn-holder d-flex align-items-center justify-content-start gap-1 mb-2">
                @can('create_categories')
                    <button type="button" class="main-btn" data-bs-toggle="modal" data-bs-target="#create">
                        اضافة
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    @include('dashboard.categories.create-modal')
                @endcan
                <a href="{{ route('dashboard.categories.index') }}" type="button" class="main-btn btn-main-color">الكل:
                    {{ App\Models\Category::count() }}</a>
                <a href="{{ route('dashboard.categories.index', ['status' => 'yes']) }}" type="button"
                    class="btn btn-success">مفعل:
                    {{ App\Models\Category::active()->count() }}</a>
                <a href="{{ route('dashboard.categories.index', ['status' => 'no']) }}" type="button"
                    class="btn btn-danger">غير
                    مفعل:
                    {{ App\Models\Category::inactive()->count() }}</a>
            </div>

            <div class="box-search">
                <form action="">
                    <img src="{{ asset('dashboard/img/icons/search.png') }}" alt="icon" />
                    <input type="search" id="" value="{{ request('search') }}" name="search"
                        placeholder="@lang('Search')" />
                </form>
            </div>

        </div>
        <div class="table-responsive">
            <table class="main-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>متفرع من </th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->parent?->name ?? '---' }}</td>
                            <td>
                                <span class="badge {{ $item->status->color() }}">{{ $item->status->name() }}</span>
                            </td>
                            <td class="d-flex gap-2">
                                @can('update_categories')
                                    <button type="button" class="btn btn-info btn-sm text-white mx-1" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $item->id }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                @endcan
                                @can('delete_categories')
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @endcan
                                @include('dashboard.categories.delete-modal', ['item' => $item])
                                @include('dashboard.categories.edit-modal', ['item' => $item])

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $items->links() }}
        </div>
    </div>
@endsection
