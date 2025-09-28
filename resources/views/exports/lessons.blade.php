<table class="main-table" style="direction: rtl">
    <thead>
        <tr>
            <th align="center" bgcolor="#4593e1">#</th>
            <th align="center" bgcolor="#4593e1">العنوان</th>
            <th align="center" bgcolor="#4593e1">الكورس</th>
            <th align="center" bgcolor="#4593e1">الفيديو</th>
            <th align="center" bgcolor="#4593e1">الحالة</th>
            <th align="center" bgcolor="#4593e1">المده</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center"> {{ $item->title }}</td>
                <td align="center"> {{ $item->course->title }} </td>
                <td align="center"> {{ display_file($item->video_url) }}</td>
                <td align="center">{{ $item->status->name() }} </td>
                <td align="center"> {{ $item->duration }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
