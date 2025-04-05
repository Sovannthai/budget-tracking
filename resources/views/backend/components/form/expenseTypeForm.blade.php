<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="customer_id" class="form-label">@lang('Customer')</label>
            <select id="customer_id" name="customer_id"
                class="form-control select2 @error('customer_id') is-invalid @enderror" required>
                <option value="" disabled selected>@lang('Select Customer')</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}"
                        {{ (isset($incomeType) && $incomeType->customer_id == $customer->id) || old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->first_name }} {{ $customer->last_name }}
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label for="icon" class="form-label">@lang('Icon')</label>
            <select id="icon" name="icon" class="form-control select2 @error('icon') is-invalid @enderror">
                <option value="">@lang('Select an emoji')</option>
                <option value="💰"
                    {{ (isset($incomeType) && $incomeType->icon == '💰') || old('icon') == '💰' ? 'selected' : '' }}>💰
                    @lang('Money Bag')</option>
                <option value="💵"
                    {{ (isset($incomeType) && $incomeType->icon == '💵') || old('icon') == '💵' ? 'selected' : '' }}>💵
                    @lang('Dollar Bill')</option>
                <option value="💸"
                    {{ (isset($incomeType) && $incomeType->icon == '💸') || old('icon') == '💸' ? 'selected' : '' }}>💸
                    @lang('Money with Wings')</option>
                <option value="🪙"
                    {{ (isset($incomeType) && $incomeType->icon == '🪙') || old('icon') == '🪙' ? 'selected' : '' }}>🪙
                    @lang('Coin')</option>
                <option value="💎"
                    {{ (isset($incomeType) && $incomeType->icon == '💎') || old('icon') == '💎' ? 'selected' : '' }}>💎
                    @lang('Gem')</option>
                <option value="💼"
                    {{ (isset($incomeType) && $incomeType->icon == '💼') || old('icon') == '💼' ? 'selected' : '' }}>💼
                    @lang('Briefcase')</option>
                <option value="🏦"
                    {{ (isset($incomeType) && $incomeType->icon == '🏦') || old('icon') == '🏦' ? 'selected' : '' }}>🏦
                    @lang('Bank')</option>
                <option value="📈"
                    {{ (isset($incomeType) && $incomeType->icon == '📈') || old('icon') == '📈' ? 'selected' : '' }}>📈
                    @lang('Chart Increasing')</option>
                <option value="🏆"
                    {{ (isset($incomeType) && $incomeType->icon == '🏆') || old('icon') == '🏆' ? 'selected' : '' }}>🏆
                    @lang('Trophy')</option>
                <option value="🤝"
                    {{ (isset($incomeType) && $incomeType->icon == '🤝') || old('icon') == '🤝' ? 'selected' : '' }}>🤝
                    @lang('Handshake')</option>
                <option value="💹"
                    {{ (isset($incomeType) && $incomeType->icon == '💹') || old('icon') == '💹' ? 'selected' : '' }}>💹
                    @lang('Chart with Upward Trend')</option>
                <option value="💳"
                    {{ (isset($incomeType) && $incomeType->icon == '💳') || old('icon') == '💳' ? 'selected' : '' }}>💳
                    @lang('Credit Card')</option>
                <option value="💱"
                    {{ (isset($incomeType) && $incomeType->icon == '💱') || old('icon') == '💱' ? 'selected' : '' }}>💱
                    @lang('Currency Exchange')</option>
                <option value="🏭"
                    {{ (isset($incomeType) && $incomeType->icon == '🏭') || old('icon') == '🏭' ? 'selected' : '' }}>🏭
                    @lang('Factory')</option>
                <option value="👨‍💼"
                    {{ (isset($incomeType) && $incomeType->icon == '👨‍💼') || old('icon') == '👨‍💼' ? 'selected' : '' }}>
                    👨‍💼 @lang('Businessman')</option>
                <option value="👩‍💼"
                    {{ (isset($incomeType) && $incomeType->icon == '👩‍💼') || old('icon') == '👩‍💼' ? 'selected' : '' }}>
                    👩‍💼 @lang('Businesswoman')</option>
            </select>
            @error('icon')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label for="name" class="form-label">@lang('Name')</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="@lang('Enter income type name')" value="{{ isset($incomeType) ? $incomeType->name : old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label for="description" class="form-label">@lang('Description')</label>
            <textarea id="description" name="description" rows="3"
                class="form-control @error('description') is-invalid @enderror" placeholder="@lang('Enter description')">{{ isset($incomeType) ? $incomeType->description : old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
