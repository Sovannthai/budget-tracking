<div class="grid-layout d-none">
    <div class="row">
        @forelse ($customers as $customer)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card customer-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="flex-shrink-0 me-3">
                                @include('backend.components.table.show_image_table',[
                                    'field_name' => $customer->image,
                                    'id'         => $customer->id,
                                    'image_path' => 'uploads/all_photo/',
                                    'class'      => 'rounded-circle img-thumbnail grid-img'
                                ])
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $customer->first_name }} {{ $customer->last_name }}</h5>
                                <small class="text-muted">ID: {{ $customer->contact_id }}</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input status" type="checkbox" 
                                    id="status-{{ $customer->id }}" data-id="{{ $customer->id }}" 
                                   {{ $customer->status ? 'checked' : '' }}>
                            </div>
                        </div>
                        
                        <ul class="list-unstyled mb-3">
                            <li class="mb-1">
                                <i class="fas fa-venus-mars me-2 text-primary"></i>
                                <span class="text-capitalize">{{ $customer->gender }}</span>
                            </li>
                            <li class="mb-1">
                                <i class="fas fa-birthday-cake me-2 text-primary"></i>
                                {{ $customer->dob ? date('d M Y', strtotime($customer->dob)) : 'N/A' }}
                            </li>
                            <li class="mb-1">
                                <i class="fas fa-phone me-2 text-primary"></i>
                                {{ $customer->phone ?: 'N/A' }}
                            </li>
                            <li class="mb-1">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                {{ $customer->email ?: 'N/A' }}
                            </li>
                            <li>
                                <i class="fas fa-clock me-2 text-primary"></i>
                                {{ $customer->created_at ? date('d M Y, H:i a', strtotime($customer->created_at)) : '' }}
                            </li>
                        </ul>
                        
                        <div class="d-flex justify-content-end">
                            @include('backend.components.modal_open_with_route.main_modal',[
                                'route_view'      => 'customers.show',
                                'row'             => $customer,
                                'modal_id_name'   => 'viewCustomerModal',
                                'class_btn_modal' => 'btn-sm view_customer',
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
                                'btn_class'    => 'btn-sm'
                            ])
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0 text-white">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    @lang('No customers found')
                </div>
            </div>
        @endforelse
    </div>
    
    @if (count($customers) != 0)
        @include('backend.components.table.paginate', ['items' => $customers])
    @endif
</div>