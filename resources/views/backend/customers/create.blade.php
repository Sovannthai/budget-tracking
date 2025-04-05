@extends('backend.layouts.app')
@section('title', __('Add Customer'))
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    @include('backend.components.table.header_table', [
                        'icon_name'        => 'fa-user-friends',
                        'header_text'      => __('Add Customer'),
                        'sub_header_title' => __('Add a new customer here')
                    ])
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('backend.components.form.customerForm', [
                            'customer' => null,
                        ])
                        @include('backend.components.form.btn.btn_form', [
                            'btn_back_name'   => __('Back to Customers'),
                            'btn_submit_name' => __('Save Customer'),
                            'route_back'      => 'customers.index',
                        ])
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection