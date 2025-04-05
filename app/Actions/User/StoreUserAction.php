<?php

namespace App\Actions\User;

use Carbon\Carbon;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreUserAction
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
    * Handle the action.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return void
    */
    public function handle($request)
    {
        $user           = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone    = $request->phone;
        $user->address  = $request->address;

        if ($request->hasFile('image')) {
            $user->image = $this->uploadImage($request->file('image'));
        }
        $role = Role::findOrFail($request->role);
        $user->assignRole($role->name);

        $user->save();
        
        return $user;
    }
}
