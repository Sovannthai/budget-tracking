@extends('frontend.layout')

@section('title', 'About Us')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">About Us</h1>
        <div class="card">
            <div class="card-body">
                @if(isset($businessSetting) && !empty($businessSetting->business_info['about_us']))
                    {!! $businessSetting->business_info['about_us'] !!}
                @else
                    <p>About us information is currently being updated. Please check back later.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 