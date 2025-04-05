@extends('backend.layouts.app')
@section('title', __('Income Type Management'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            @include('backend.components.table.header_table', [
                'icon_name'        => 'fa-file-invoice-dollar',
                'header_text'      => __('Expense Types'),
                'sub_header_title' => __('Manage your expense types here'),
                'btn_title'        => __('Add Expense Type'),
            ])
            <a href="#" class="btn btn-primary float-end text-capitalize" data-bs-toggle="modal"
                data-bs-target="#create_expense_type">
                <i class="fa fa-plus-circle"></i> @lang('Add New')</a>
            @include('backend.expenseType.create', ['customers' => $customers])
        </div>
        <div class="card-body table-wrapper">
            <div class="table-responsive">
                <table class="table text-nowrap table-hover align-middle">
                    <thead>
                        <tr>
                            <th>@lang('Icon')</th>
                            <th>@lang('Customer')</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Description')</th>
                            <th>@lang('Created at')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>

                    <body>
                        @forelse ($expenseTypes as $row)
                            <tr>
                                <td>{{ $row->icon }}</td>
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
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->description }}</td>
                                <td>{{ $row->created_at ? date('d M Y, H:i a', strtotime($row->created_at)) : '' }}
                                </td>
                                <td>
                                    <a href="#" class="me-2" data-bs-toggle="modal"
                                        data-bs-target="#edit_expense_type-{{ $row->id }}" title="@lang('Edit')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 24 24">
                                            <path fill="#305cff"
                                                d="M20.22 2H7.78C6.8 2 6 2.8 6 3.78v12.44C6 17.2 6.8 18 7.78 18h12.44c.98 0 1.78-.79 1.78-1.78V3.78C22 2.8 21.2 2 20.22 2m-9.16 13H9v-2.06l6.06-6.06l2.06 2.06zm7.64-7.65l-1 1l-2.05-2.05l1-1c.21-.22.56-.22.77 0l1.28 1.28c.22.21.22.56 0 .77M4 6H2v14a2 2 0 0 0 2 2h14v-2H4z"
                                                stroke-width="0.5" stroke="" />
                                        </svg>
                                    </a>
                                    @include('backend.components.table.action_btn', [
                                        'route_delete'   => 'expense-types.destroy',
                                        'row'            => $row,
                                        'tooltip_delete' => __('Delete Income Type'),
                                        'tooltip_edit'   => __('Edit Income Type'),
                                    ])
                                </td>
                            </tr>
                            @include('backend.expenseType.edit', [
                                'incomeType' => $row,
                                'customers'  => $customers,
                            ])
                        @empty
                            @include('backend.components.table.not_found_item', [
                                'total_colspan' => 6,
                                'messages'      => __('No Expense types found'),
                            ])
                        @endforelse
                    </body>
                </table>
            </div>
            @if (count($expenseTypes) != 0)
                @include('backend.components.table.paginate', ['items' => $expenseTypes])
            @endif
        </div>
    </div>
@endsection
