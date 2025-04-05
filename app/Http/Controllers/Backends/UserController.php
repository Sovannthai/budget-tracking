<?php

namespace App\Http\Controllers\Backends;

use App\Actions\User\StoreUserAction;
use App\Actions\User\UpdateUserAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Return all users
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::latest()->paginate($this->limit());
        return view('backend.users.index', compact('users'));
    }

    /**
     * Return the form to create a new user
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        return view('backend.users.create', compact('roles'));
    }

    /**
     * Store users
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = StoreUserAction::run($request);

            DB::commit();

            $output = [
                'success' => 1,
                'msg'     => __('User :name created successfully.', ['name' => $user->name])
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg'     => __('Something went wrong. Please try again: ') . $e->getMessage()
            ];
        }
        return redirect()->route('user.index')->with($output);
    }

    /**
     * Edit user
     * @param \App\Models\User $user
     * @return \Illuminate\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('backend.users.edit', compact('user', 'roles'));
    }

    /**
     * Update user
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        try {

            DB::beginTransaction();

            $user = UpdateUserAction::run($request, $user);

            DB::commit();
            $output = [
                'success' => 1,
                'msg'     => __('User :name updated successfully.', ['name' => $user->name])
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $output = [
                'success' => 0,
                'msg'     => __('Something went wrong. Please try again: ') . $e->getMessage()
            ];
        }
        return redirect()->route('user.index')->with($output);
    }

    /**
     * Delete User 
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        try {
            $old_photo_path = $user->image;
            if ($old_photo_path && File::exists(public_path('uploads/all_photo/' . $old_photo_path))) {
                File::delete(public_path('uploads/all_photo/' . $old_photo_path));
            }
            $user->delete();
            $output = [
                'success' => 1,
                'msg'     => __('User :name deleted successfully.', ['name' => $user->name])
            ];
        } catch (\Exception $e) {
            $output = [
                'success' => 0,
                'msg'     => __('User can not be deleted.')
            ];
        }
        return redirect()->route('user.index')->with($output);
    }
}
