<div class="row">
    <div class="mb-3 col-sm-4">
        <label for="name" class="form-label">{{ __('Name') }}</label>
        <input type="text" name="name" id="name" value="{{ isset($user) ? $user->name : old('name') }}"
            class="form-control" placeholder="Enter name" required>
    </div>
    <div class="mb-3 col-sm-4">
        <label for="phone" class="form-label">{{ __('Phone') }}</label>
        <input type="text" name="phone" id="phone" value="{{ isset($user) ? $user->phone : old('phone') }}"
            class="form-control" placeholder="Enter phone" required>
    </div>
    <div class="mb-3 col-sm-4">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input type="email" name="email" id="email" value="{{ isset($user) ? $user->email : old('email') }}"
            class="form-control" placeholder="Enter email" required>
    </div>
    <div class="mb-3 col-sm-6">
        <label for="password" class="form-label">{{ __('Password') }}</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password"
            {{ isset($user) ? '' : 'required' }}>
        @if (isset($user))
            <small class="text-muted">{{ __('Leave blank to keep current password') }}</small>
        @endif
    </div>
    <div class="mb-3 col-sm-6">
        <label for="role" class="form-label">{{ __('Role') }}</label>
        <select name="role" id="role" class="form-control ambitious-form-loading select2">
            <option value="">{{ __('Select') }}</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}"
                    {{ isset($user) && $user->hasRole($role->name) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3 col-sm-12">
        <label for="address" class="form-label">{{ __('Address') }}</label>
        <textarea name="address" id="address" class="form-control" rows="5" placeholder="Enter address">{{ isset($user) ? $user->address : old('address') }}</textarea>
    </div>
    <div class="mb-3 col-md-12">
        <label for="image" class="col-form-label">{{ __('Profile') }}</label>
        <input type="file" name="image" id="image" class="dropify" data-height="100"
            data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="2M"
            data-default-file="{{ isset($user) && $user->image ? asset('uploads/all_photo/' . $user->image) : '' }}">
        @if (isset($user) && $user->image)
            <input type="hidden" name="old_image" value="{{ $user->image }}">
        @endif
        @error('image')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
