<div class="row">
    <div class="mb-3 col-sm-6">
        <label for="first_name" class="form-label">{{ __('First Name') }}</label>
        <input type="text" name="first_name" id="first_name" value="{{ isset($customer) ? $customer->first_name : old('first_name') }}"
            class="form-control" placeholder="Enter first name" required>
    </div>
    <div class="mb-3 col-sm-6">
        <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
        <input type="text" name="last_name" id="last_name" value="{{ isset($customer) ? $customer->last_name : old('last_name') }}"
            class="form-control" placeholder="Enter last name" required>
    </div>
    <div class="mb-3 col-sm-6">
        <label for="gender" class="form-label">{{ __('Gender') }}</label>
        <select name="gender" id="gender" class="form-control" required>
            <option value="">Select Gender</option>
            <option value="male" {{ (isset($customer) && $customer->gender == 'male') || old('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ (isset($customer) && $customer->gender == 'female') || old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ (isset($customer) && $customer->gender == 'other') || old('gender') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>
    <div class="mb-3 col-sm-6">
        <label for="dob" class="form-label">{{ __('Date of Birth') }}</label>
        <input type="text" name="dob" id="dob" value="{{ isset($customer) ? $customer->dob : old('dob') }}" 
            class="form-control flatpickr-date" placeholder="Select date" autocomplete="off">
    </div>
    <div class="mb-3 col-sm-6">
        <label for="phone" class="form-label">{{ __('Phone') }}</label>
        <input type="text" name="phone" id="phone" value="{{ isset($customer) ? $customer->phone : old('phone') }}"
            class="form-control" placeholder="Enter phone" required>
    </div>
    <div class="mb-3 col-sm-6">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input type="email" name="email" id="email" value="{{ isset($customer) ? $customer->email : old('email') }}"
            class="form-control" placeholder="Enter email" required>
    </div>
    <div class="mb-3 col-sm-12">
        <label for="address" class="form-label">{{ __('Address') }}</label>
        <textarea name="address" id="address" class="form-control" rows="5" placeholder="Enter address">{{ isset($customer) ? $customer->address : old('address') }}</textarea>
    </div>
    <div class="mb-3 col-md-12">
        <label for="image" class="col-form-label">{{ __('Profile') }}</label>
        <input type="file" name="image" id="image" class="dropify" data-height="100"
            data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="2M"
            data-default-file="{{ isset($customer) && $customer->image ? asset('uploads/all_photo/' . $customer->image) : '' }}">
        @if (isset($customer) && $customer->image)
            <input type="hidden" name="old_image" value="{{ $customer->image }}">
        @endif
        @error('image')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
