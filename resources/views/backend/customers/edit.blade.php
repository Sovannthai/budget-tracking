@extends('backend.layouts.app')
@section('title', __('Edit Customer'))
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    @include('backend.components.table.header_table', [
                        'icon_name'        => 'fa-user-friends',
                        'header_text'      => __('Edit Customer'),
                        'sub_header_title' => __('Update customer information'),
                    ])
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.update',$customer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.components.form.customerForm', [
                            'customer' => $customer,
                        ])
                        @include('backend.components.form.btn.btn_form', [
                            'btn_back_name'   => __('Back to Customers'),
                            'btn_submit_name' => __('Update Customer'),
                            'route_back'      => 'customers.index',
                        ])
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection