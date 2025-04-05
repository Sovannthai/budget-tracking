<?php

namespace App\Actions\Customer;

use Carbon\Carbon;
use App\Models\Customer;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreCustomerAction
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
    public function handle($request)
    {
        $customer = new Customer();
        $customer->first_name = $request->first_name;
        $customer->last_name  = $request->last_name;
        $customer->gender     = $request->gender;
        $customer->dob        = $request->dob;
        $customer->email      = $request->email;
        $customer->phone      = $request->phone;
        $customer->address    = $request->address;

        if ($request->hasFile('image')) {
            $customer->image = $this->uploadImage($request->file('image'));
        }
        $customer->save();
        return $customer;
    }
}
