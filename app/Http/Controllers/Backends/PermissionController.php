<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:show permission', ['only' => ['show', 'index']]);
    //     $this->middleware('permission:create permission', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:update permission', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::latest()->paginate($this->limit());
        return view('backend.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        $name = $request->input('name');
        $guardName = 'web';
        Permission::create([
            'name'       => $name,
            'guard_name' => $guardName
        ]);
        $output = [
            'success' => 1,
            'msg'     => __('Permission added successfully.')
        ];
        return redirect()->route('permission.index')->with($output);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('backend.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        $name = $request->input('name');
        $guardName = 'web';
        Permission::where('id', $id)->update([
            'name'       => $name,
            'guard_name' => $guardName
        ]);
        $output = [
            'success' => 1,
            'msg'     => __('Permission updated successfully.')
        ];
        return redirect()->route('permission.index')->with($output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            $output = [
                'success' => 1,
                'msg'     => __('Permission deleted successfully.')
            ];
        } catch (\Exception $e) {
            $output = [
                'success' => 0,
                'msg'     => __('Permission can not be deleted.')
            ];
        }

        return redirect()->route('permission.index')->with($output);
    }
}
