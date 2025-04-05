    <!-- Modal -->
    <div class="modal fade" id="editPermissionModal-{{ $permission->id }}" tabindex="-1" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPermissionModalLabel">@lang('Edit Permission')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-material form-horizontal" action="{{ route('permission.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">@lang('Permission')</label>
                            <input type="text" value="{{ $permission->name }}" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="@lang('Type name permission')">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
