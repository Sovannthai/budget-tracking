@extends('frontend.layout')

@section('title', 'Privacy Policy')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Privacy Policy</h1>
        <div class="card">
            <div class="card-body">
                @if(isset($businessSetting) && !empty($businessSetting->business_info['privacy_and_policy']))
                    {!! $businessSetting->business_info['privacy_and_policy'] !!}
                @else
                    <p>Privacy policy is currently being updated. Please check back later.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection