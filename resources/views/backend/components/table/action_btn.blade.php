@if (isset($route_edit))
    <a href="{{ route($route_edit, $row->id) }}" class="me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang(isset($tooltip_edit) ? $tooltip_edit : __('Edit'))">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
            <path fill="#305cff"
                d="M20.22 2H7.78C6.8 2 6 2.8 6 3.78v12.44C6 17.2 6.8 18 7.78 18h12.44c.98 0 1.78-.79 1.78-1.78V3.78C22 2.8 21.2 2 20.22 2m-9.16 13H9v-2.06l6.06-6.06l2.06 2.06zm7.64-7.65l-1 1l-2.05-2.05l1-1c.21-.22.56-.22.77 0l1.28 1.28c.22.21.22.56 0 .77M4 6H2v14a2 2 0 0 0 2 2h14v-2H4z"
                stroke-width="0.5" stroke="" />
        </svg>
    </a>
@endif
@if(isset($route_view))
    <a href="{{ route($route_view, $row->id) }}" class="me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang(isset($tooltip_view) ? $tooltip_view : __('View'))">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#305cff" d="M6 8c0-2.21 1.79-4 4-4s4 1.79 4 4s-1.79 4-4 4s-4-1.79-4-4m3.14 11.75L8.85 19l.29-.75c.7-1.75 1.94-3.11 3.47-4.03c-.82-.14-1.69-.22-2.61-.22c-4.42 0-8 1.79-8 4v2h7.27c-.04-.09-.09-.17-.13-.25M17 18c-.56 0-1 .44-1 1s.44 1 1 1s1-.44 1-1s-.44-1-1-1m6 1c-.94 2.34-3.27 4-6 4s-5.06-1.66-6-4c.94-2.34 3.27-4 6-4s5.06 1.66 6 4m-3.5 0a2.5 2.5 0 0 0-5 0a2.5 2.5 0 0 0 5 0" stroke-width="0.5" stroke=""/></svg>
    </a>
@endif
@if (isset($route_delete))
    <form action="{{ route($route_delete, $row->id) }}" method="POST" style="display: inline;"
        class="form-delete-{{ $row->id }}">
        @csrf
        @method('DELETE')
        <button type="submit" data-id="{{ $row->id }}" data-href="{{ route($route_delete, $row->id) }}"
            style="border: none; background: none; padding: 0;" class="btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang(isset($tooltip_delete) ? $tooltip_delete : __('Delete'))">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                <path fill="#ff3535"
                    d="m20.37 8.91l-1 1.73l-12.13-7l1-1.73l3.04 1.75l1.36-.37l4.33 2.5l.37 1.37zM6 19V7h5.07L18 11v8a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2"
                    stroke-width="0.5" stroke="" />
            </svg>
        </button>
    </form>
@endif
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: "@lang('Are you sure?')",
                    text: "@lang('You will not be able to revert this!')",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "@lang('Cancel')",
                    confirmButtonText: "@lang('Yes, delete it!')"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
