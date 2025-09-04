@extends('dashboard.layouts.backend', ['title' => 'المشرفين'])

@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>
            <div class="large">المشرفين</div>
        </div>

        <div class="bar-obtions d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
            <div class="row flex-fill g-3">
                <div class="d-flex align-items-center gap-2 mt-2">
                    <a href="{{ route('dashboard.admins.index') }}" class="main-btn btn-sm bg-primary">الكل :
                        {{ App\Models\User::admins()->count() }}</a>
                    <a href="" class="main-btn btn-sm bg-success">مفعلين :
                        {{ App\Models\User::admins()->active()->count() }}</a>
                    <a href="" class="main-btn btn-sm  bg-danger">غير مفعلين :
                        {{ App\Models\User::admins()->inactive()->count() }}</a>
                    @can('create_admins')
                        <a href="{{ route('dashboard.admins.create') }}" class="main-btn btn-purple btn btn-sm"><i
                                class="fas fa-plus"></i> اضافة مشرف جديد
                        </a>
                    @endcan
                </div>
            </div>
            <div class="box-search">
                <img src="img/icons/search.png" alt="icon" />
                <input type="search" name="" id="" placeholder="بحث" />
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
                        <th>الصلاحيه</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td> <img style="width: 60px; height:60px" src="{{ display_file($item->image) }}" alt=""
                                    srcset=""></td>
                            <td> {{ $item->name }}</td>
                            <td> {{ $item->email }}</td>
                            <td> {{ $item->phone }}</td>
                            <td> <span class="badge {{ $item->status->color() }}">{{ $item->status->name() }}</span> </td>
                            <td> <span class="badge bg-secondary ">{{ $item->roles->first()?->name }}</span> </td>
                            <td>
                                <div class="btn-holder d-flex align-items-center gap-3">
                                    @can('update_admins')
                                        <a href="{{ route('dashboard.admins.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm text-white mx-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_admins')
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#delete{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                                @include('dashboard.admins.delete-model', ['item' => $item])
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
