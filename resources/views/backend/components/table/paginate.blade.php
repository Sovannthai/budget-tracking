<div class="col-12 d-flex flex-row flex-wrap paginate-component">
    <div class="col-12 col-sm-6 text-sm-left">
        {{ __('Showing') }} {{ $items->firstItem() }} {{ __('to') }}
        {{ $items->lastItem() }} {{ __('of') }} {{ $items->total() }} {{ __('entries') }}
    </div>
    <div class="col-12 col-sm-6 text-right">
        <nav>
            <ul class="pagination justify-content-end">
                {{ $items->links() }}
            </ul>
        </nav>
    </div>
</div>