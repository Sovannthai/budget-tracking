<?php

namespace Database\Seeders;

use App\Models\BusinessSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessSetting::create([
            'business_info' => [
                'social_media' => [
                    'facebook' => '',
                    'twitter' => '',
                    'instagram' => '',
                    'linkedin' => '',
                ],
                'about_us' => 'About Us',
                'term_and_condition' => 'Terms and Conditions',
                'privacy_and_policy' => 'Privacy Policy',
            ]
        ]);
    }
} 