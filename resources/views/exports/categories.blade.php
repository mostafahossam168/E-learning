<table class="main-table" style="direction: rtl">
    <thead>
        <tr>
            <th align="center" bgcolor="#4593e1">#</th>
            <th align="center" bgcolor="#4593e1">الاسم</th>
            <th align="center" bgcolor="#4593e1">متفرع من </th>
            <th align="center" bgcolor="#4593e1">الكورسات</th>
            <th align="center" bgcolor="#4593e1">الحالة</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center"> {{ $item->name }}</td>
                <td align="center"> {{ $item->parent?->name }} </td>
                <td align="center"> {{ $item->courses()->count() }}</td>
                <td align="center">{{ $item->status->name() }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
