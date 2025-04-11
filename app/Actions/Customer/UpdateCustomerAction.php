<?php

namespace App\Actions\Customer;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCustomerAction
{
    use AsAction;
    /*
    * Upload image
    *
    * @param  \Illuminate\Http\UploadedFile  $image
    * @return string
    */
    public function uploadImage($image)
    {
        $extension = $image->getClientOriginalExtension();
        $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $extension;
        $image->move(public_path('uploads/all_photo/'), $imageName);
        return $imageName;
    }
    /*
    * Update customer
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Customer  $customer
    * @return \App\Models\Customer
    */
    public function handle($request, $customer)
    {
        $old_photo_path       = $customer->image;
        $customer->first_name = $request->first_name;
        $customer->last_name  = $request->last_name;
        $customer->gender     = $request->gender;
        $customer->dob        = $request->dob;
        $customer->email      = $request->email;
        $customer->phone      = $request->phone;
        $customer->address    = $request->address;

        if ($request->hasFile('image')) {
            $customer->image = $this->uploadImage($request->file('image'));
            if ($old_photo_path && File::exists(public_path('uploads/all_photo/' . $old_photo_path))) {
                File::delete(public_path('uploads/all_photo/' . $old_photo_path));
            }
        }

        $customer->save();

        return $customer;
    }
}
