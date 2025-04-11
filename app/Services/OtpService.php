<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\EmailVerificationOtp;
use App\Notifications\EmailVerificationOtp as NotificationsEmailVerificationOtp;

class OtpService
{
    public function generateOtp(Customer $customer)
    {
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);
        
        // Delete any existing OTPs for this customer
        EmailVerificationOtp::where('customer_id', $customer->id)->delete();
        
        // Create a new OTP record
        EmailVerificationOtp::create([
            'customer_id' => $customer->id,
            'email'       => $customer->email,
            'otp'         => $otp,
            'expires_at'  => Carbon::now()->addMinutes(5),
        ]);
        
        // Send the OTP notification
        $customer->notify(new NotificationsEmailVerificationOtp($otp));
        
        return $otp;
    }
    
    public function validateOtp(Customer $customer, $otp)
    {
        $otpRecord = EmailVerificationOtp::where('customer_id', $customer->id)
            ->where('otp', $otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();
        if (!$otpRecord) {
            return false;
        }
        
        // Mark customer as verified
        $customer->email_verified = 1;
        $customer->email_verified_at = Carbon::now();
        $customer->save();
        
        $otpRecord->delete();
        
        return true;
    }
}