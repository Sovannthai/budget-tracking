<div class="modal fade" id="create_expense_type" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang('Create Expense Type')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-material form-horizontal" action="{{ route('expense-types.store') }}" method="POST">
                    @csrf
                    @include('backend.components.form.expenseTypeForm', [
                        'expenseType' => null,
                        'customers'  => $customers,
                    ])
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.select2').select2({
            dropdownParent: $('#create_expense_type'),
            width: '100%',
            templateResult: formatEmojiOption,
            templateSelection: formatEmojiOption
        });
        function formatEmojiOption(option) {
            if (!option.id) { return option.text; }
            return $('<span><span style="font-size: 1.2em; margin-right: 8px;">' + $(option.element).val() + '</span>' + option.text + '</span>');
        }
    });
</script>