<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class BusinessSettingController extends Controller
{
    public function aboutUs()
    {
        $businessSetting = BusinessSetting::first();
        return view('frontend.about_us', compact('businessSetting'));
    }

    public function termsAndConditions()
    {
        $businessSetting = BusinessSetting::first();
        return view('frontend.terms_and_conditions', compact('businessSetting'));
    }

    public function privacyPolicy()
    {
        $businessSetting = BusinessSetting::first();
        return view('frontend.privacy_policy', compact('businessSetting'));
    }
} 