@if(isset($items))
<div class="col-12 d-flex flex-row flex-wrap paginate-component p-2">
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
@endif

@if(isset($paginatedArray) && count($paginatedArray) > 0)
@php
    $collection = collect($paginatedArray);
    
    $page = request()->get('page', 1);
    
    $perPage = 5;
    
    $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
        $collection->forPage($page, $perPage),
        $collection->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );
@endphp
<div class="col-12 d-flex flex-row flex-wrap paginate-component p-2">
    <div class="col-12 col-sm-6 text-sm-left">
        {{ __('Showing') }} {{ $paginator->firstItem() ?? 0 }} {{ __('to') }}
        {{ $paginator->lastItem() ?? 0 }} {{ __('of') }} {{ $paginator->total() }} {{ __('entries') }}
    </div>
    <div class="col-12 col-sm-6 text-right">
        <nav>
            <ul class="pagination justify-content-end">
                {{ $paginator->links() }}
            </ul>
        </nav>
    </div>
</div>
@endif