@extends('backend.layouts.app')
@section('title', __('Expenses Management'))
@section('content')
@include('backend.expenses.partials._style_table_layout')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            @include('backend.components.table.header_table', [
                'icon_name'        => 'fa-money-bill-wave',
                'header_text'      => __('Expenses'),
                'sub_header_title' => __('Manage your expenses here'),
                'btn_title'        => __('Add Expense'),
                'route_create'     => 'expenses.create',
            ])
            <div class="ms-2">
                <button class="btn btn-secondary layout-btn active" data-layout="table" id="table-view-btn">
                    <i class="fas fa-table"></i> {{ __('Table') }}
                </button>
                <button class="btn btn-secondary layout-btn" data-layout="grid" id="grid-view-btn">
                    <i class="fas fa-th-large"></i> {{ __('Grid') }}
                </button>
            </div>
        </div>
        <div class="card-body table-wrapper">
            <!-- Table View -->
            @include('backend.expenses.partials._table_view')

            <!-- Grid View -->
            @include('backend.expenses.partials._grid_view')
        </div>
    </div>
@endsection