@extends('backend.layouts.app')
@section('title', __('Edit Income'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            @include('backend.components.table.header_table', [
                'icon_name'        => 'fa-money-bill-wave',
                'header_text'      => __('Update income'),
                'sub_header_title' => __('Update income here'),
            ])
        </div>
        <div class="card-body">
            <form class="form-material form-horizontal" action="{{ route('incomes.update',$income->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('backend.components.form.incomeForm', [
                        'income'    => $income,
                        'customers' => $customers,
                        'incomeTypes' => $incomeTypes,
                    ])
                    @include('backend.components.form.btn.btn_form', [
                        'btn_submit_name' => __('Update Income'),
                        'btn_back_name'   => __('Back to Income List'),
                        'route_back'      => 'incomes.index',
                    ])
            </form>
        </div>
    </div>
@endsection