@extends('frontend.layout')

@section('title', 'Terms and Conditions')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Terms and Conditions</h1>
        <div class="card">
            <div class="card-body">
                @if(isset($businessSetting) && !empty($businessSetting->business_info['term_and_condition']))
                    {!! $businessSetting->business_info['term_and_condition'] !!}
                @else
                    <p>Terms and conditions are currently being updated. Please check back later.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 