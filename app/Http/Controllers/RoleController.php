<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google\Service\Directory\Resource\Roles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $userObj = Auth::user();

        if ($userObj == null)
            return 0;
        $roles = Role::get();


        return view('roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $rolePermission = Permission::select('name', 'id')->orderBy('id', 'asc')->get();
        return view('roles.create')->with('rolePermission', $rolePermission);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
        'name' => 'required|unique:roles,name',
        'permissions' => 'array'
    ]);

    // Create Role
    $role = Role::create(['name' => $request->name]);

    // Assign permissions if any selected
    $permissions = $request['permissions'];
    if (count($permissions) > 0) {
        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            //Fetch the newly created role and assign permission
            // $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }
    }

    // Success message
    return redirect()->route('roles.index')
                     ->with('success', 'Role successfully created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
        $rolesAllPermission = $role->permissions->pluck('id')->toArray();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
        $rolesAllPermission = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::select('name', 'id')->orderBy('id', 'asc')->get();

        return view('roles.edit')
       ->with('rolesAllPermission', $rolesAllPermission)
       ->with('role',$role)
       ->with('permissions', $permissions);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        // Update role name
        $role->update(['name' => $request->name]);

        // Update permissions (replace old ones)
        if (!empty($request->permissions)) {
            // Convert IDs to names for Spatie
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissions);
        } else {
            // If none selected, remove all permissions
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')
                        ->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
