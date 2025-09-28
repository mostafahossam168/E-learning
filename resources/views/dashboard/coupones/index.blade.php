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
                        {{ $count_all }}</a>
                    <a href="{{ route('dashboard.coupones.index', ['status' => 'yes']) }}"
                        class="main-btn btn-sm bg-success">مفعلين : {{ $count_active }}</a>
                    <a href="{{ route('dashboard.coupones.index', ['status' => 'no']) }}"
                        class="main-btn btn-sm  bg-danger">غير مفعلين : {{ $count_inactive }}</a>
                </div>

                <form action="{{ route('dashboard.coupones.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-3">
                            <select name="course_id" class="form-select">
                                <option value="">اختيار الكورس</option>
                                <option value="all">الكل</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" @selected(request('course_id') == $course->id)>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- فلتر النوع -->
                        <div class="col-3">
                            <select name="discount_type" class="form-select">
                                <option value="">اختيار النوع</option>
                                @foreach (\App\enums\DiscountTypeCoupone::cases() as $type)
                                    <option value="{{ $type }}" @selected(request('discount_type') == $type->value)>
                                        {{ $type->name() }}
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
                        <div class="col-3">
                            <div class="d-flex align-items-center gap-2">
                                <label for="from"> من </label>
                                <input class="form-control" type="datetime-local" id=""
                                    value="{{ request('start_date') }}" name="start_date" />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex align-items-center gap-2">
                                <label for="from"> الى </label>
                                <input class="form-control" type="datetime-local" id=""
                                    value="{{ request('end_date') }}" name="end_date" />
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
                            <td> {{ $item->course?->title ?? 'الكل' }}</td>
                            <td> <span
                                    class="badge {{ $item->discount_type->color() }}">{{ $item->discount_type->name() }}</span>
                            </td>
                            <td> {{ $item->discount_value }}</td>
                            <td> {{ $item->usage_limit }}</td>
                            <td> {{ $item->used_count }}</td>
                            <td>{{ date('h:ia | Y-m-d ', strtotime($item->start_date)) }}</td>
                            <td>{{ date('h:ia | Y-m-d ', strtotime($item->end_date)) }}</td>
                            <td>
                                @if ($item->end_date < now())
                                    <span class="badge bg-secondary">منتهي</span>
                                @else
                                    <span class="badge {{ $item->status->color() }}">{{ $item->status->name() }}</span>
                                @endif
                            </td>
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
