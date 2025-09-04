@extends('dashboard.layouts.backend')
@section('contant')
    <div class="main-side">
        <div class="main-title">
            <div class="small">الرئيسية</div>
            <div class="large">المصاريف</div>
        </div>
        <ul class="nav nav-tabs step-anchor my-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tap-1" type="button" role="tab"
                    aria-selected="true">
                    <i class="fa-solid fa-circle-info icon"></i>
                    <span class="title"> المصروفات</span>
                    <div class="title-small">أنشئ مصروف</div>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tap-2" type="button" role="tab"
                    aria-selected="false">
                    <i class="fa-solid fa-chart-bar icon"></i>
                    <span class="title">نوع المصروف</span>
                    <div class="title-small">أضف نوع مصروف</div>
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tap-1" role="tabpanel">
                <form action="" id="collapse-add" class="collapse mb-4">
                    <div class="issue-main-info">
                        <div class="content-header">
                            اضف مصروف جديد
                            <a data-bs-toggle="collapse" href="#collapse-add" aria-expanded="false"
                                class="main-btn btn-main-color">
                                إغلاق <i class="fas fa-minus"></i>
                            </a>
                        </div>
                        <div class="row g-4">
                            <div class="col-12 col-md-4 col-lg-3">
                                <label class="special-input">
                                    <span>العنوان</span>
                                    <div class="box-input">
                                        <input type="text" name="" id="" />
                                    </div>
                                </label>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3">
                                <label class="special-label" for="tax">
                                    قسم المصروف</label>
                                <select name="" id="tax" class="form-select select-setting">
                                    <option value="">تجربة</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3">
                                <label class="special-input">
                                    <span>المبلغ</span>
                                    <div class="box-input">
                                        <input type="number" name="" id="" />
                                    </div>
                                </label>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3">
                                <label class="special-input">
                                    <span> هل يوجد ضريبة ؟ </span>
                                    <input type="checkbox" name="" id="" />
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <a class="main-btn"> حفظ </a>
                        </div>
                    </div>
                </form>
                <div class="issue-main-info">
                    <div class="bar-obtions d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <a data-bs-toggle="collapse" href="#collapse-add" aria-expanded="false"
                                class="main-btn btn-main-color">
                                إضافة <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                        <div class="box-search">
                            <img src="img/icons/search.png" alt="icon" />
                            <input type="search" name="" id="" placeholder="بحث" />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="main-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>العنوان</th>
                                    <th>قسم المصروف</th>
                                    <th>المبلغ</th>
                                    <th>شامل الضريبة</th>
                                    <th>غير شامل الضريبة</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>تجربة مصروف</td>
                                    <td>تجربة قسم</td>
                                    <td>500</td>
                                    <td>500</td>
                                    <td>500</td>
                                    <td>
                                        <div class="btn-holder d-flex align-items-center gap-3">
                                            <button>
                                                <i class="fas fa-pen text-info icon-table"></i>
                                            </button>
                                            <button>
                                                <i class="fas fa-trash text-danger icon-table"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2">
                        <div class="px-3 py-2 bg-main text-white fs-13px rounded-3">مجموع المصروفات – 0 ريال</div>
                        <div class="px-3 py-2 bg-main text-white fs-13px rounded-3">المصروفات بالضريبة - 0 ريال
                        </div>
                        <div class="px-3 py-2 bg-main text-white fs-13px rounded-3">بدون الضريبة - 0 ريال</div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tap-2" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-4">
                        <form action="" class="issue-main-info">
                            <div class="content-header">
                                اضف نوع مصروف جديد
                            </div>
                            <label class="special-input">
                                <span>نوع المصروف</span>
                                <div class="box-input">
                                    <input type="text" name="" id="" />
                                </div>
                            </label>
                            <div class="d-flex justify-content-center mt-4">
                                <a class="main-btn"> حفظ </a>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <form action="" class="issue-main-info">
                            <div class="content-header">
                                عرض كل أنواع المصروفات
                            </div>
                            <div class="bar-obtions d-flex align-items-center justify-content-end flex-wrap gap-3 mb-4">
                                <div class="box-search">
                                    <img src="img/icons/search.png" alt="icon" />
                                    <input type="search" name="" id="" placeholder="بحث" />
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="main-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>نوع المصروف </th>
                                            <th>أنشئت في </th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>
                                                <div class="btn-holder d-flex align-items-center gap-3">
                                                    <button>
                                                        <i class="fas fa-pen text-info icon-table"></i>
                                                    </button>
                                                    <button>
                                                        <i class="fas fa-trash text-danger icon-table"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
