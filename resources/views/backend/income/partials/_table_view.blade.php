<div class="table-view">
    <div class="table-responsive">
        <table class="table text-nowrap table-hover text-center">
            <thead>
                <tr>
                    <th>@lang('No.')</th>
                    <th>@lang('Customer')</th>
                    <th>@lang('Type')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Income Date')</th>
                    <th>@lang('Actions')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($incomes as $row)
                    <tr class="hover-shadow transition-all">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                <span>
                                    <a class="example-image-link"
                                        href="{{ $row->customer->image ? asset('uploads/all_photo/' . $row->customer->image) : asset('uploads/images/defualt.png') }}"
                                        data-lightbox="lightbox-{{ $row->id }}">
                                        <img class="avatar rounded-circle"
                                            src="{{ $row->customer->image ? asset('uploads/all_photo/' . $row->customer->image) : asset('uploads/images/defualt.png') }}"
                                            alt="profile" width="50px" height="50px" style="cursor:pointer" />
                                    </a>
                                </span>
                                <span class="ms-2">
                                    {{ optional($row->customer)->first_name }} {{ optional($row->customer)->last_name }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center">
                                @if($row->incomeType && $row->incomeType->icon)
                                    <span class="me-2">{{ $row->incomeType->icon }}</span>
                                @endif
                                <span>{{ optional($row->incomeType)->name }}</span>
                            </div>
                        </td>
                        <td>$ {{ number_format($row->amount,2)}}</td>
                        <td>{{ $row->date ? date('d M Y', strtotime($row->date)) : '' }}
                        </td>
                        <td>
                            @include('backend.components.table.action_btn', [
                                'route_delete'   => 'incomes.destroy',
                                'route_edit'     => 'incomes.edit',
                                'row'            => $row,
                                'tooltip_delete' => __('Delete Income'),
                                'tooltip_edit'   => __('Edit Income'),
                            ])
                        </td>
                    </tr>
                @empty
                    @include('backend.components.table.not_found_item', [
                        'total_colspan' => 6,
                        'messages'      => __('No income types found'),
                    ])
                @endforelse
            </tbody>
        </table>
    </div>
    @if (count($incomes) != 0)
        @include('backend.components.table.paginate', ['items' => $incomes])
    @endif
</div>