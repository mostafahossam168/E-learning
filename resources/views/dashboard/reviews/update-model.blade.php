<div class="modal fade" id="delete{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل حالة الاشتراك</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.reviews.update', $item->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="">الحالة</label><br>
                            <select name="status" id="" class="form-control">
                                <option value="1" @selected($item->status == 1)>مفعل</option>
                                <option value="0" @selected($item->status == 0)>غير مفعل</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary btn-sm px-3" data-bs-dismiss="modal">نعم</button>
                </div>
            </form>
        </div>
    </div>
</div>
