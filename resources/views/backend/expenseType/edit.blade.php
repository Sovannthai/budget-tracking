<div class="modal fade" id="edit_expense_type-{{ $row->id }}" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang('Edit Expense Type')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-material form-horizontal" action="{{ route('expense-types.update',$row->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('backend.components.form.expenseTypeForm', [
                        'expenseType' => $incomeType,
                        'customers'  => $customers,
                    ])
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.select2').select2({
            dropdownParent: $('#edit_income_type-{{ $row->id }}'),
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