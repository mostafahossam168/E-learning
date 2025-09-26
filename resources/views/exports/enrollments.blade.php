<table class="main-table" style="direction: rtl">
    <thead>
        <tr>
            <th align="center" bgcolor="#4593e1">#</th>
            <th align="center" bgcolor="#4593e1">التاريخ</th>
            <th align="center" bgcolor="#4593e1">الكورس</th>
            <th align="center" bgcolor="#4593e1">المعلم</th>
            <th align="center" bgcolor="#4593e1">الطالب</th>
            <th align="center" bgcolor="#4593e1">السعر</th>
            <th align="center" bgcolor="#4593e1">الحالة</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center"> {{ date('h:ia | Y-m-d ', strtotime($item->created_at)) }}</td>
                @php
                    $course = App\Models\Course::find($item->course_id);
                @endphp
                <td align="center"> {{ $course->title }}</td>
                <td align="center"> {{ $course->teacher->name }}</td>
                @php
                    $student = App\Models\User::find($item->student_id);
                @endphp
                <td align="center"> {{ $student->name }}</td>
                <td align="center"> {{ $item->price }} $</td>
                <td align="center">{{ $item->status ? 'مفعل' : 'غير مفعل' }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" align="center">المجموع </td>
            <td align="center">{{ $items->sum('price') }}</td>
        </tr>
    </tbody>
</table>
