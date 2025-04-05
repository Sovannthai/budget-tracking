<div class="row">
    <div class="col-md-6 mb-3">
        <label for="customer_id">@lang('Customer')</label>
        <select name="customer_id" id="customer_id" class="form-control select2" required>
            <option value="">@lang('Select Customer')</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" {{ (old('customer_id', $income->customer_id ?? null) == $customer->id) ? 'selected' : '' }}>{{ $customer->first_name }} {{ $customer->last_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="income_type_id">@lang('Income Type')</label>
        <select name="income_type_id" id="income_type_id" class="form-control select2" required>
            <option value="">@lang('Select Income Type')</option>
            @foreach ($incomeTypes as $row)
                <option value="{{ $row->id }}" {{ (old('income_type_id', $income->income_type_id ?? null) == $row->id) ? 'selected' : '' }}>
                    @if($row->icon)
                    {{ $row->icon }}
                    @endif
                    {{ $row->name }} ({{ $row->customer->first_name }} {{ $row->customer->last_name }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="amount">@lang('Amount')</label>
        <input type="number" name="amount" id="amount" class="form-control" required placeholder="@lang('Enter Amount')" value="{{ old('amount', $income->amount ?? '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="date">@lang('Income Date')</label>
        <input type="date" name="date" id="date" class="form-control flatpickr-date" required placeholder="@lang('Select Date')" value="{{ old('date', $income->date ?? '') }}">
    </div>
    <div class="col-md-12 mb-3">
        <label for="description">@lang('Description')</label>
        <textarea name="description" id="description" class="form-control" rows="3" placeholder="@lang('Enter Description')">{{ old('description', $income->description ?? '') }}</textarea>
    </div>
</div>