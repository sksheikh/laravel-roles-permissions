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

    public function edit()
    {
        return view('permissions.edit');
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
        // Validate and update the permission
    }
    public function destroy($id)
    {
        // Delete the permission
    }
}
