@extends('backend.layouts.app')
<style>
    .hide {
        display: none;
    }
</style>
@section('title', __('Business Setting'))
@section('content')
    <div class="card">
        <div class="card-title text-uppercase mt-2 ml-3 mb-0">@lang('Business Setting')</div>
        <div class="card-body">
            <form action="{{ route('business_setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <label for=""> @lang('Logo')</label> ( 500px * 240px )<span class="text-danger"> *</span>
                        <input name="business_logo" id="business_logo" type="file" class="dropify" data-height="100"
                            value="{{ @$business_setting->business_logo }}"
                            data-default-file="{{ asset('uploads/all_photo/' . @$business_setting->business_logo) }}" /><br>
                        <input type="hidden" name="business_logo" value="{{ @$business_setting->business_logo }}"
                            id="photo-trigger">
                    </div>
                    <div class="col-sm-6">
                        <label for=""> @lang('Web Logo')</label> ( 500px * 240px )<span class="text-danger">
                            *</span>
                        <input name="web_logo" id="web_logo" type="file" class="dropify" data-height="100"
                            value="{{ @$business_setting->web_logo }}"
                            data-default-file="{{ asset('uploads/all_photo/' . @$business_setting->web_logo) }}" /><br>
                        <input type="hidden" name="web_logo" value="{{ @$business_setting->web_logo }}" id="photo-trigger">
                    </div>
                </div>
                @can('update setting')
                    <div class="mt-5">
                        <button type="submit" class="btn btn-outline-success float-lg-right">@lang('Update Business Setting')</button>
                    </div>
                @endcan
            </form>
        </div>
    </div>
@endsection
