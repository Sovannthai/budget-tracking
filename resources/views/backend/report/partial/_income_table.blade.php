<table class="table text-nowrap table-hover align-middle">
    <thead>
        <tr>
            <th>Date</th>
            <th>Customer</th>
            <th>Description</th>
            <th>Income Type</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($income_reports as $row)
            <tr>
                <td class="date">{{ $row->date ? date('d M Y', strtotime($row->date)) : '' }}</td>
                <td>
                    @if ($row->customer)
                        @if ($row->customer->first_name && $row->customer->last_name)
                            {{ $row->customer->first_name }} {{ $row->customer->last_name }}
                        @elseif ($row->customer->phone)
                            {{ $row->customer->phone }}
                        @elseif ($row->customer->email)
                            {{ $row->customer->email }}
                        @else
                            No customer information
                        @endif
                    @else
                        No customer
                    @endif
                </td>
                <td>{{ $row->description ?? 'No description' }}</td>
                <td>
                    <span class="income-type type-salary">
                        {{ optional($row->incomeType)->icon }} {{ optional($row->incomeType)->name }}
                    </span>
                </td>
                <td class="amount">$ {{ number_format($row->amount, 2) }}</td>
            </tr>
        @empty
            @include('backend.components.table.not_found_item', [
                'total_colspan' => 5,
                'messages'      => __('No income reports found'),
            ])
        @endforelse
    </tbody>
</table>
@include('backend.components.table.paginate', [
    'items' => $income_reports,
])
