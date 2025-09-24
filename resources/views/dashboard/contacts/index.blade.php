@extends('dashboard.layouts.backend', ['title' => 'تواصل معنا'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>
            <div class="large">تواصل معنا</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    <a href="{{ route('dashboard.contacts.index') }}" class="main-btn btn-main-color">الكل :
                        {{ App\Models\Contact::count() }}</a>
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
                        <th>الاسم</th>
                        <th>البريد الالكترونى</th>
                        <th>الهاتف</th>
                        <th>الرساله</th>
                        <th>التاريخ</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td> {{ $item->name }}</td>
                            <td> {{ $item->email }}</td>
                            <td> {{ $item->phone }}</td>
                            <td> {{ $item->message }}</td>
                            <td> {{ date('h:ia | Y-m-d ', strtotime($item->created_at)) }}</td>
                            {{-- <td>{{ date('h:ia | Y-m-d ', strtotime($item->end_date)) }}</td> --}}
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('delete_contacts')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.contacts.delete-model', ['item' => $item])
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
