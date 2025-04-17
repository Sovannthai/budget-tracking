@extends('backend.layouts.app')
@section('title', __('Customers'))
@section('content')
@include('backend.customers.partials.layout_table')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                @include('backend.components.table.header_table', [
                    'icon_name'        => 'fa-user-friends',
                    'header_text'      => __('Customers'),
                    'sub_header_title' => __('Manage your customers here'),
                    'btn_title'        => __('Add Customer'),
                    'route_create'     => 'customers.create',
                ])
            <div class="ms-2 view-toggle">
                <button class="btn btn-secondary layout-btn active" data-layout="table" id="table-view-btn">
                    <i class="fas fa-table"></i> {{ __('Table') }}
                </button>
                <button class="btn btn-secondary layout-btn" data-layout="grid" id="grid-view-btn">
                    <i class="fas fa-th-large"></i> {{ __('Grid') }}
                </button>
            </div>
            </div>
            <div class="card-body">
                <!-- Table Layout -->
                @include('backend.customers.partials._table_view')
                
                <!-- Grid Layout (Hidden by default) -->
                @include('backend.customers.partials._grid_view')
            </div>
        </div>
    </div>
</section>
    @include('backend.components.modal_open_with_route.main_modal', [
        'modal_name' => '.view_customer',
        'modal_id_name' => 'viewCustomerModal',
    ])
@endsection
@push('scripts')
<script>
    $(document).on('change', '.status', function() {
        let id = $(this).data('id');
        let status = $(this).is(':checked') ? true : false;

        $.ajax({
            url: '{{ route('update-status.customer') }}',
            type: 'POST',
            data: {
                id: id,
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Notiflix.Notify.success(response.msg);
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    Notiflix.Notify.failure(response.msg);
                }
            },
            error: function(xhr, success, error) {
                console.error("AJAX Error:", xhr.responseText);
            }
        });
    });
</script>
@endpush
