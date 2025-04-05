<div class="table-layout">
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center modern-table">
            <thead>
                <tr>
                    <th></th>
                    <th>@lang('No.')</th>
                    <th>@lang('First Name')</th>
                    <th>@lang('Last Name')</th>
                    <th>@lang('Gender')</th>
                    <th>@lang('Date of Birth')</th>
                    <th>@lang('Phone')</th>
                    <th>@lang('Email')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Created at')</th>
                    <th>@lang('Actions')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>
                            @include('backend.components.table.show_image_table',[
                            'field_name' => $customer->image,
                            'id'         => $customer->id,
                            'image_path' => 'uploads/all_photo/',
                        ])
                        </td>
                        <td>{{ $customer->contact_id }}</td>
                        <td>{{ $customer->first_name }}</td>
                        <td>{{ $customer->last_name }}</td>
                        <td class="text-capitalize">{{ $customer->gender }}</td>
                        <td>{{ $customer->dob ? date('d M Y', strtotime($customer->dob)) : '' }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input status" type="checkbox" 
                                    id="status-{{ $customer->id }}" data-id="{{ $customer->id }}" 
                                   {{ $customer->status ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>{{ $customer->created_at ? date('d M Y, H:i a', strtotime($customer->created_at)) : '' }}
                        </td>
                        <td>
                            @include('backend.components.modal_open_with_route.main_modal',[
                                'route_view'      => 'customers.show',
                                'row'             => $customer,
                                'modal_id_name'   => 'viewCustomerModal',
                                'class_btn_modal' => '.view_customer',
                                'tooltip_view'    => __('View Customer'),
                                
                            ])
                            @include('backend.components.table.action_btn', [
                                'route_delete' => 'customers.destroy',
                                'row'          => $customer,
                                'route_edit'   => 'customers.edit',
                                'route_show'   => 'customers.show',
                                'tooltip_edit' => __('Edit Customer'),
                                'tooltip_view' => __('View Customer'),
                                'tooltip_delete' => __('Delete Customer'),
                            ])
                        </td>
                    </tr>
                @empty
                    @include('backend.components.table.not_found_item', [
                        'total_colspan' => 11,
                        'messages'      => __('No customers found')
                    ])
                @endforelse
            </tbody>
        </table>
    </div>
    @if (count($customers) != 0)
        @include('backend.components.table.paginate', ['items' => $customers])
    @endif
</div>