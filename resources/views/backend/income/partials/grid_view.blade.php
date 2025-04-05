<div class="grid-view d-none">
    <div class="row">
        @forelse ($incomes as $row)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card h-100 user-card shadow-sm">
                    <div class="card-body p-3">
                        <div class="text-center mb-3 user-avatar">
                            <a class="example-image-link"
                                href="{{ $row->customer->image ? asset('uploads/all_photo/' . $row->customer->image) : asset('uploads/images/defualt.png') }}"
                                data-lightbox="grid-lightbox-{{ $row->id }}">
                                <img class="avatar rounded-circle mb-2"
                                    src="{{ $row->customer->image ? asset('uploads/all_photo/' . $row->customer->image) : asset('uploads/images/defualt.png') }}"
                                    alt="profile" width="80px" height="80px" style="cursor:pointer" />
                            </a>
                        </div>
                        <h6 class="card-title text-center mb-3">
                            {{ optional($row->customer)->first_name }} {{ optional($row->customer)->last_name }}
                        </h6>
                        <div class="income-details">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">@lang('Type'):</span>
                                <span class="fw-bold">
                                    @if($row->incomeType && $row->incomeType->icon)
                                        <span class="me-1">{{ $row->incomeType->icon }}</span>
                                    @endif
                                    {{ optional($row->incomeType)->name }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">@lang('Amount'):</span>
                                <span class="fw-bold">{{ number_format($row->amount,2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">@lang('Date'):</span>
                                <span class="fw-bold">{{ $row->date ? date('d M Y', strtotime($row->date)) : '' }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            @include('backend.components.table.action_btn', [
                                'route_delete'   => 'incomes.destroy',
                                'route_edit'     => 'incomes.edit',
                                'row'            => $row,
                                'tooltip_delete' => __('Delete Income'),
                                'tooltip_edit'   => __('Edit Income'),
                            ])
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">@lang('No income types found')</h4>
            </div>
        @endforelse
    </div>
    @if (count($incomes) != 0)
        @include('backend.components.table.paginate', ['items' => $incomes])
    @endif
</div>