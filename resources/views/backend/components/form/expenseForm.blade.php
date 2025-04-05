<div class="row">
    <div class="col-md-6 mb-3">
        <label for="customer_id">@lang('Customer')</label>
        <select name="customer_id" id="customer_id" class="form-control select2" required>
            <option value="">@lang('Select Customer')</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" {{ (old('customer_id', $expense->customer_id ?? null) == $customer->id) ? 'selected' : '' }}>{{ $customer->first_name }} {{ $customer->last_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="expense_type_id">@lang('Expense Type')</label>
        <select name="expense_type_id" id="expense_type_id" class="form-control select2" required>
            <option value="">@lang('Select Expense Type')</option>
            @foreach ($expenseTypes as $expenseType)
                <option value="{{ $expenseType->id }}" {{ (old('expense_type_id', $expense->expense_type_id ?? null) == $expenseType->id) ? 'selected' : '' }}>
                    @if($expenseType->icon)
                    {{ $expenseType->icon }}
                    @endif  
                    {{ $expenseType->name }} ({{ $expenseType->customer->first_name }} {{ $expenseType->customer->last_name }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="amount">@lang('Amount')</label>
        <input type="number" name="amount" id="amount" class="form-control" required placeholder="@lang('Enter Amount')" value="{{ old('amount', $expense->amount ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="date">@lang('Expense Date')</label>
        <input type="date" name="date" id="date" class="form-control flatpickr-date" required placeholder="@lang('Select Date')" value="{{ old('date', $expense->date ?? '') }}">
    </div>
    <div class="col-md-12 mb-3">
        <label for="description">@lang('Description')</label>
        <textarea name="description" id="description" class="form-control" rows="3" placeholder="@lang('Enter Description')">{{ old('description', $expense->description ?? '') }}</textarea>
    </div>
</div>