@extends('backend.layouts.app')
@section('title', __('Create User'))
@section('content')
    <div class="">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                @include('backend.components.table.header_table', [
                    'icon_name'        => 'fa-user-plus',
                    'header_text'      => 'Create User',
                    'sub_header_title' => 'Fill in the details below to create a new user',
                    'btn_title'        => 'Save User',
                ])
            </div>
            <div class="card-body">
                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('backend.components.form.userForm', [
                        'user'  => null,
                        'roles' => $roles,
                    ])
                    @include('backend.components.form.btn.btn_form', [
                        'btn_back_name'   => __('Back to Users'),
                        'btn_submit_name' => __('Create User'),
                        'route_back'      => 'user.index',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
