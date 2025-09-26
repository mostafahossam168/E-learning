<table class="main-table" style="direction: rtl">
    <thead>
        <tr>
            <th align="center" bgcolor="#4593e1">#</th>
            <th align="center" bgcolor="#4593e1">الاسم</th>
            <th align="center" bgcolor="#4593e1">الصوره</th>
            <th align="center" bgcolor="#4593e1">البريد الالكتروني</th>
            <th align="center" bgcolor="#4593e1">الهاتف</th>
            <th align="center" bgcolor="#4593e1">الصلاحيه</th>
            <th align="center" bgcolor="#4593e1">الحالة</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center"> {{ $item->name }}</td>
                <td align="center">{{ display_file($item->image) }}</td>
                <td align="center"> {{ $item->email }} </td>
                <td align="center"> {{ $item->phone }} </td>
                <td align="center"> {{ $item->roles->first()?->name }} </td>
                <td align="center">{{ $item->status->name() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
