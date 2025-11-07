<?php

namespace App\Http\Controllers\AdminSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    // ✅ Show all roles
    public function index()
    {
        $roles = Role::select('id', 'name', 'created_at')->latest()->get();
        $totalRoles = $roles->count();

        return inertia('AdminSetting/Roles/Index', compact('roles', 'totalRoles'));
    }

    // ✅ Show create role form
    public function create()
    {
        return inertia('AdminSetting/Roles/Form', [
            'role' => null
        ]);
    }

   // ✅ Store new role
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:roles,name',
    ]);

    Role::create([
        'name' => $request->name,
        'guard_name' => 'web', // 👈 added line
    ]);

    return redirect()->route('admin.roles.index')
        ->with('success', 'Role created successfully');
}

    // ✅ Show edit form
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return inertia('AdminSetting/Roles/Form', [
            'role' => $role
        ]);
    }

    // ✅ Update role
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => "required|string|max:255|unique:roles,name,$id",
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }

    // ✅ Delete role
    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success', 'Role deleted successfully');
    }
}
