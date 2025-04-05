
@if(isset($header_text))
<h4 class="mb-0 text-primary">
    <i class="fas {{ $icon_name }} me-2"></i>{{ __($header_text) }} <br>
    <p>{{ __($sub_header_title) }}</p>
</h4>
@endif
@if (isset($route_create) && $route_create != null)
    <a href="{{ route($route_create) }}" class="btn btn-primary">
        <span><i class="fa fa-plus-circle"></i> {{ __($btn_title) }}</span>
    </a>
@endif
