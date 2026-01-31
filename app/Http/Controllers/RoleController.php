<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        return Inertia::render('Roles/Index', [
            // Get all roles with their permissions count
            'roles' => Role::with('permissions')->get(),
            // Get all available permissions so we can check boxes later
            'permissions' => Permission::all() 
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        
        // Sync permissions (e.g., ['create user', 'delete user'])
        if($request->has('permissions')){
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'Role Created Successfully!');
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
            'permissions' => 'array'
        ]);

        $role->update(['name' => $request->name]);

        if($request->has('permissions')){
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'Role Updated!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with('success', 'Role Deleted!');
    }
}