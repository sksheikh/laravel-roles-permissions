<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create', compact('permissions'));
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.edit', compact('role', 'permissions', 'hasPermissions'));
    }

    public function show()
    {
        return view('roles.show');
    }

    public function store(Request $request)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name|min:3',
            'permissions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->route('roles.create')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            //store
            $role = Role::create(['name' => $request->name]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return redirect()->route('roles.index')
                ->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating role: ' . $e->getMessage());
            return redirect()->route('roles.create')
                ->with('error', 'Something went wrong, please try again.')
                ->withInput();
        }
    }

    public function Update($id, Request $request)
    {
        $role = Role::findOrFail($id);
        //validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:roles,name,' . $id . 'id',
            'permissions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->route('roles.create')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            //store
            $role->name = $request->name;
            $role->save();

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return redirect()->route('roles.index')
                ->with('success', 'Role updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return redirect()->route('roles.create')
                ->with('error', 'Something went wrong, please try again.')
                ->withInput();
        }
    }



    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::find($id);

        if ($role === null) {
            session()->flash('error', 'Role not found.');
            return response()->json(['status' => false]);
        }

        try {
            $role->delete();
            session()->flash('success', 'Role deleted successfully.');
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            session()->flash('error', 'Something went wrong, please try again.');
            return response()->json(['status' => false]);
        }
    }
}
