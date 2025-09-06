<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة قسم جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.categories.store') }}" method="POST">
                <div class="modal-body row g-3">
                    @csrf
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الاسم</label>
                            <input type="text" name="name" id="" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">متفرع من</label>
                            <select name="parent_id" id="" class="form-control">
                                <option value="">-- اختر --</option>
                                @foreach (App\Models\Category::select('id', 'name')->get() as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الحالة</label>
                            <select name="status" id="" class="form-control">
                                @foreach (collect(\App\enums\StatusCategory::cases())->toArray() as $status)
                                    <option value="{{ $status }}">
                                        {{ $status->name() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">@lang('Save')</button>
                </div>
            </form>

        </div>
    </div>
</div>
