@if (isset($route_view))
    <div class="d-inline-flex align-items-center">
        <a href="#" class="me-2 {{ $class_btn_modal ?? '' }}" data-bs-toggle="tooltip" data-bs-placement="top"
            title="@lang(isset($tooltip_view) ? $tooltip_view : __('View'))" data-bs-href="{{ route($route_view, $row->id) }}"
            data-bs-target="#{{ $modal_id_name }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                <path fill="#305cff"
                    d="M6 8c0-2.21 1.79-4 4-4s4 1.79 4 4s-1.79 4-4 4s-4-1.79-4-4m3.14 11.75L8.85 19l.29-.75c.7-1.75 1.94-3.11 3.47-4.03c-.82-.14-1.69-.22-2.61-.22c-4.42 0-8 1.79-8 4v2h7.27c-.04-.09-.09-.17-.13-.25M17 18c-.56 0-1 .44-1 1s.44 1 1 1s1-.44 1-1s-.44-1-1-1m6 1c-.94 2.34-3.27 4-6 4s-5.06-1.66-6-4c.94-2.34 3.27-4 6-4s5.06 1.66 6 4m-3.5 0a2.5 2.5 0 0 0-5 0a2.5 2.5 0 0 0 5 0"
                    stroke-width="0.5" stroke="" />
            </svg>
        </a>
    </div>
@endif
@if (isset($modal_name))
    <div class="modal fade {{ $modal_name }}" id="{{ $modal_id_name }}" tabindex="-1" aria-labelledby="ModalLabel"
        aria-hidden="true">
    </div>
@endif
@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '[data-bs-target="#{{ $modal_id_name }}"]', function(e) {
                e.preventDefault();
                var url = $(this).attr('data-bs-href');
                $("#{{ $modal_id_name }}").load(url, function() {
                    let modal = new bootstrap.Modal(document.getElementById(
                    '{{ $modal_id_name }}'));
                    modal.show();

                    // Handle modal close event to properly remove backdrop
                    $('#{{ $modal_id_name }}').on('hidden.bs.modal', function() {
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', '');
                    });
                });
            });
        });
    </script>
@endpush
