<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:show role', ['only' => ['show', 'index']]);
    //     $this->middleware('permission:create role', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:update role', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete role', ['only' => ['destroy']]);
    // }
    public function index()
    {
        $roles = Role::paginate($this->limit());
        return view('backend.role.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::get()->groupBy(function ($data) {
            return $data->module;
        });
        return view('backend.role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $roleName = $request->input('name');
        $permissions = $request->input('permissions');

        $role = new Role;
        $role->name = $roleName;
        $role->save();

        if (!empty($permissions)) {
            $validPermissions = Permission::whereIn('id', $permissions)->get();

            if ($validPermissions->count() != count($permissions)) {
                $notFoundPermissions = array_diff($permissions, $validPermissions->pluck('id')->toArray());
                return redirect()->back()->withErrors(['permissions' => 'Invalid permissions: ' . implode(', ', $notFoundPermissions)]);
            }

            $role->syncPermissions($validPermissions);
        }

        $output = [
            'success' => 1,
            'msg' => __('Role added successfully.')
        ];
        return redirect()->route('role.index')->with($output);
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::get()->groupBy(function ($data) {
            return $data->module;
        });
        $rolePermissions = [];
        foreach ($role->permissions as $rolePerm) {
            $rolePermissions[] = $rolePerm->name;
        }
        return view('backend.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
            // Uncomment this if you want to validate description
            // 'description' => 'sometimes|string|max:255',
        ]);

        $roleName = $request->input('name');
        $permissions = $request->input('permissions', []);

        $role = Role::findOrFail($id);
        $role->name = $roleName;
        $role->save();

        if (!empty($permissions)) {
            $validPermissions = Permission::whereIn('name', $permissions)->get();

            if ($validPermissions->count() != count($permissions)) {
                $notFoundPermissions = array_diff($permissions, $validPermissions->pluck('name')->toArray());
                return redirect()->back()->withErrors(['permissions' => 'Invalid permissions: ' . implode(', ', $notFoundPermissions)]);
            }

            $role->syncPermissions($validPermissions);
        } else {
            $role->syncPermissions([]);
        }

        $output = [
            'success' => 1,
            'msg' => __('Role updated successfully.')
        ];
        return redirect()->route('role.index')->with($output);
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::get()->groupBy(function ($data) {
            return $data->module;
        });
        $rolePermissions = [];
        foreach ($role->permissions as $rolePerm) {
            $rolePermissions[] = $rolePerm->name;
        }
        return view('backend.role.show', compact(['role', 'permissions', 'rolePermissions']));
    }
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->revokePermissionTo($role->permissions);
        $role->delete();
        $output = [
            'success' => 1,
            'msg' => __('Role deleted successfully.')
        ];
        return redirect()->route('role.index')->with($output);
    }
}
