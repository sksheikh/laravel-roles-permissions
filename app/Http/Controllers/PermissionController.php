<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(20);
        return view('permissions.index',compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    public function show()
    {
        return view('permissions.show');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:permissions|min:3',
            ]
        );

        if($validator->fails()) {
            return redirect()->route('permissions.create')->withErrors($validator)->withInput();
        }

        // Create the permission
        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3|unique:permissions,name,'.$permission->id,
            ]
        );

        if($validator->fails()) {
            return redirect()->route('permissions.edit', $permission->id)->withErrors($validator)->withInput();
        }

        // Update the permission
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $permission = Permission::find($id);

        if($permission === null){
            session()->flash('error', 'Permission not found');
            return response()->json([
                'success' => false,
            ]);
        }

        $permission->delete();
        session()->flash('success', 'Permission deleted successfully');
        return response()->json([
            'success' => true,
        ]);
    }
}
