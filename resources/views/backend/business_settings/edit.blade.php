@extends('backend.layouts.app')

@section('title', 'Business Settings')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Business Settings</h2><br>
                </div>
                <div class="breadcrumb-wrapper col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Business Settings
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('business-settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="social-media-tab" data-bs-toggle="tab" href="#social-media" aria-controls="social-media" role="tab" aria-selected="true">
                                        <i data-feather="share-2"></i> Social Media
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="about-us-tab" data-bs-toggle="tab" href="#about-us" aria-controls="about-us" role="tab" aria-selected="false">
                                        <i data-feather="info"></i> About Us
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="terms-tab" data-bs-toggle="tab" href="#terms" aria-controls="terms" role="tab" aria-selected="false">
                                        <i data-feather="file-text"></i> Terms & Conditions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="privacy-tab" data-bs-toggle="tab" href="#privacy" aria-controls="privacy" role="tab" aria-selected="false">
                                        <i data-feather="shield"></i> Privacy Policy
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- Social Media Tab -->
                                <div class="tab-pane active" id="social-media" aria-labelledby="social-media-tab" role="tabpanel">
                                    <div class="row mt-2">
                                        <div class="col-md-6 mb-1">
                                            <label class="form-label" for="facebook">Facebook</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i data-feather="facebook"></i></span>
                                                <input type="text" class="form-control" id="facebook" name="facebook" placeholder="Facebook URL" value="{{ $businessSetting->business_info['social_media']['facebook'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-1">
                                            <label class="form-label" for="twitter">Twitter</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i data-feather="twitter"></i></span>
                                                <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Twitter URL" value="{{ $businessSetting->business_info['social_media']['twitter'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-1">
                                            <label class="form-label" for="instagram">Instagram</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i data-feather="instagram"></i></span>
                                                <input type="text" class="form-control" id="instagram" name="instagram" placeholder="Instagram URL" value="{{ $businessSetting->business_info['social_media']['instagram'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-1">
                                            <label class="form-label" for="linkedin">LinkedIn</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i data-feather="linkedin"></i></span>
                                                <input type="text" class="form-control" id="linkedin" name="linkedin" placeholder="LinkedIn URL" value="{{ $businessSetting->business_info['social_media']['linkedin'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- About Us Tab -->
                                <div class="tab-pane" id="about-us" aria-labelledby="about-us-tab" role="tabpanel">
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label class="form-label" for="about_us">About Us Content</label>
                                            <textarea class="form-control" id="about_us" name="about_us" rows="10">{{ $businessSetting->business_info['about_us'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms & Conditions Tab -->
                                <div class="tab-pane" id="terms" aria-labelledby="terms-tab" role="tabpanel">
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label class="form-label" for="term_and_condition">Terms & Conditions Content</label>
                                            <textarea class="form-control" id="term_and_condition" name="term_and_condition" rows="10">{{ $businessSetting->business_info['term_and_condition'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Privacy Policy Tab -->
                                <div class="tab-pane" id="privacy" aria-labelledby="privacy-tab" role="tabpanel">
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label class="form-label" for="privacy_and_policy">Privacy Policy Content</label>
                                            <textarea class="form-control" id="privacy_and_policy" name="privacy_and_policy" rows="10">{{ $businessSetting->business_info['privacy_and_policy'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize text editors for content areas
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#about_us, #term_and_condition, #privacy_and_policy',
                height: 350,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
            });
        }
    });
</script>
@endsection 