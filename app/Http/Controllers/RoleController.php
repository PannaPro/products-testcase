<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch roles excluding 'admin'
        $roles = Role::orderBy('name')->where('name', '!=', 'admin')->get();

        $user = Auth::user();

        $currentRoleNames = $user->getRoleNames();
        
        return view('roles.index', [
            'roles' => $roles,
            'currentRoleNames' => $currentRoleNames,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all permissions
        $permissions = Permission::all();

        return view('roles.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255|unique:roles,name',
                'permissions' => 'required|array|min:1',
                'permissions.*' => 'required|integer|exists:permissions,id',
            ]);

            $permissions = Permission::whereIn('id', $request->permissions)->get();
            
            // Create a new role
            $newRole = Role::create([
                'name' => $request->name,
            ]);

            // Sync permissions for the new role
            $newRole->syncPermissions($permissions);

            return redirect()->route('roles.index')->with('success', 'Role created successfully');

            } catch (ValidationException $e) {
                return redirect()->back()->withErrors($e->validator->errors())->withInput();
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        //prevent admin route access
        $role = Role::where('name', '!=', 'admin')->findOrFail($role->id);

        return view('roles.edit', [
            'permissions' => $permissions,
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:255|unique:permissions,name',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|integer|exists:permissions,id',
        ]);

        // Prevent access to 'admin' role
        $role = Role::where('name', '!=', 'admin')->findOrFail($role->id);
        
        // Update the role
        $role->update([
            'name' => $request->name,
        ]);

        $permissions = Permission::whereIn('id', $request->permissions)->get();
       
        // Sync permissions for the role
        $role->syncPermissions($permissions);

        $roles = Role::orderBy('name')->where('name', '!=', 'admin')->get();

        $user = Auth::user();

        $currentRoleNames = $user->getRoleNames();
        
        return view('roles.index', [
            'roles' => $roles,
            'currentRoleNames' => $currentRoleNames,
            ])
            ->with('alert', 'Role created success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        $roles = Role::orderBy('name')->where('name', '!=', 'admin')->get();

        return view('roles.index', ['roles' => $roles]);
    }
}
