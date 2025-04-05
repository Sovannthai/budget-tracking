@extends('backend.layouts.app')
@section('title', __('Create Expense')) 
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            @include('backend.components.table.header_table', [
                'icon_name'        => 'fa-money-bill-wave',
                'header_text'      => __('Create Expense'),
                'sub_header_title' => __('Add new expense here'),
            ])
        </div>
        <div class="card-body">
            <form class="form-material form-horizontal" action="{{ route('expenses.store') }}" method="POST">
                    @csrf
                    @include('backend.components.form.expenseForm', [
                        'expense'    => null,
                        'customers' => $customers,
                        'expenseTypes' => $expenseTypes,
                    ])
                    @include('backend.components.form.btn.btn_form', [
                        'btn_submit_name' => __('Submit Expense'),
                        'btn_back_name'   => __('Back to Expense List'),
                        'route_back'      => 'expenses.index',
                    ])
            </form>
        </div>
    </div>
@endsection