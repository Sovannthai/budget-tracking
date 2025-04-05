@extends('backend.layouts.app')
@section('title', __('Users'))
@section('content')
@include('backend.users.partials.user_layout_table')
<div class="card shadow-sm border-0 rounded-lg">
    <div class="card-header d-flex justify-content-between align-items-center py-3">
        @include('backend.components.table.header_table', [
            'icon_name'        => 'fa-users',
            'header_text'      => 'Users',
            'sub_header_title' => 'Manage your users here',
            'btn_title'        => 'Add User',
            'route_create'     => 'user.create',
        ])
        <!-- View toggle buttons -->
        <div class="ms-2">
            <button class="btn btn-secondary layout-btn active" data-layout="grid" id="table-view-btn">
            <i class="fas fa-table"></i> {{ __('Table') }}
            </button>
            <button class="btn btn-secondary layout-btn" data-layout="grid" id="grid-view-btn">
            <i class="fas fa-th-large"></i> {{ __('Grid') }}
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Table View -->
        @include('backend.users.partials._table_view')

        <!-- Grid View (hidden by default) -->
        @include('backend.users.partials._grid_view')

        @if(isset($users) && count($users) > 0)
            <div class="mt-3">
                @include('backend.components.table.paginate', ['items' => $users])
            </div>
        @endif
    </div>
</div>
@endsection
