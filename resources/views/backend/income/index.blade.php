@extends('backend.layouts.app')
@section('title', __('Income Management'))
@section('content')
    @include('backend.income.partials.income_layout_table')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            @include('backend.components.table.header_table', [
                'icon_name'        => 'fa-money-bill-wave',
                'header_text'      => __('Income'),
                'sub_header_title' => __('Manage your income here'),
                'btn_title'        => __('Add Income'),
                'route_create'     => 'incomes.create',
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
            @include('backend.income.partials._table_view')

            <!-- Grid View -->
            @include('backend.income.partials.grid_view')
        </div>
    </div>
@endsection