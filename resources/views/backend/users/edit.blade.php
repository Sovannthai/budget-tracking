@extends('backend.layouts.app')
@section('title', __('Edit User'))
@section('content')
    <div class="">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                @include('backend.components.table.header_table', [
                    'icon_name'        => 'fa-user-edit',
                    'header_text'      => 'Edit User',
                    'sub_header_title' => 'Update user information',
                    'btn_title'        => 'Update User',
                ])
            </div>
            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('backend.components.form.userForm', [
                        'user'  => $user,
                        'roles' => $roles,
                    ])
                    @include('backend.components.form.btn.btn_form', [
                        'btn_back_name'   => __('Back to Users'),
                        'btn_submit_name' => __('Update User'),
                        'route_back'      => 'user.index',
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
