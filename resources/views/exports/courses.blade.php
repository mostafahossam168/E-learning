<table class="main-table" style="direction: rtl">
    <thead>
        <tr>
            <th align="center" bgcolor="#4593e1">#</th>
            <th align="center" bgcolor="#4593e1">العنوان</th>
            <th align="center" bgcolor="#4593e1">الغلاف</th>
            <th align="center" bgcolor="#4593e1">القسم</th>
            <th align="center" bgcolor="#4593e1">المعلم</th>
            <th align="center" bgcolor="#4593e1">التفاصيل</th>
            <th align="center" bgcolor="#4593e1">السعر</th>
            <th align="center" bgcolor="#4593e1">الحالة</th>
            <th align="center" bgcolor="#4593e1">الدروس</th>
            <th align="center" bgcolor="#4593e1">الاشتراكات</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($items as $item)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center"> {{ $item->title }}</td>
                <td align="center"> {{ display_file($item->cover) }} </td>
                <td align="center"> {{ $item->category->name }}</td>
                <td align="center"> {{ $item->teacher->name }}</td>
                <td align="center"> {{ $item->description }}</td>
                <td align="center"> {{ $item->price }}</td>
                <td align="center">{{ $item->status->name() }}</td>
                <td align="center">{{ $item->lessons()->count() }}</td>
                <td align="center">{{ $item->students()->count() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
