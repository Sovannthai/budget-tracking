<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class BusinessSettingController extends Controller
{
    public function edit()
    {
        $businessSetting = BusinessSetting::first();
        
        if (!$businessSetting) {
            $businessSetting = BusinessSetting::create([
                'business_info' => [
                    'social_media' => [
                        'facebook' => '',
                        'twitter' => '',
                        'instagram' => '',
                        'linkedin' => '',
                    ],
                    'about_us' => '',
                    'term_and_condition' => '',
                    'privacy_and_policy' => '',
                ]
            ]);
        }
        
        return view('backend.business_settings.edit', compact('businessSetting'));
    }
    
    public function update(Request $request)
    {
        $businessSetting = BusinessSetting::first();
        
        if (!$businessSetting) {
            $businessSetting = new BusinessSetting();
        }
        
        $businessInfo = [
            'social_media' => [
                'facebook' => $request->facebook ?? '',
                'twitter' => $request->twitter ?? '',
                'instagram' => $request->instagram ?? '',
                'linkedin' => $request->linkedin ?? '',
            ],
            'about_us' => $request->about_us ?? '',
            'term_and_condition' => $request->term_and_condition ?? '',
            'privacy_and_policy' => $request->privacy_and_policy ?? '',
        ];
        
        $businessSetting->business_info = $businessInfo;
        $businessSetting->save();
        $output = [
            'success' => 1,
            'msg' => 'Business settings updated successfully',
        ];
        return redirect()->back()->with($output);
    }
} 