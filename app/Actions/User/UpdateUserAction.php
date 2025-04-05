<?php

namespace App\Actions\User;

use Carbon\Carbon;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUserAction
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
    /**
     * Handle the action.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \App\Models\User
     */
    public function handle($request, $user)
    {
        $user->name         = $request->name;
        $old_photo_path     = $user->image;
        $user->email        = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->phone   = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('image')) {
            $user->image = $this->uploadImage($request->file('image'));
            if ($old_photo_path && File::exists(public_path('uploads/all_photo/' . $old_photo_path))) {
                File::delete(public_path('uploads/all_photo/' . $old_photo_path));
            }
        }
        $role = Role::findOrFail($request->role);
        $user->assignRole($role->name);

        $user->save();

        return $user;
    }
}
