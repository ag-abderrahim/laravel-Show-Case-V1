<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PerName;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth');
    //     $this->middleware('role_or_permission:admin|show roles', ['only' => ['index']]);
    //     $this->middleware('role_or_permission:admin|show role', ['only' => ['show']]);
    //     $this->middleware('role_or_permission:admin|create role', ['only' => ['store']]);
    //     $this->middleware('role_or_permission:admin|edit role', ['only' => ['edit', 'update', 'updatePermissions']]);
    //     $this->middleware('role_or_permission:admin|delete role', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $roles = Role::all();
        return view('admin.pages.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required',
            ]);

            $role = Role::create(['name' => $request->name]);

            return back()->with('success', 'Rôle créé avec succès !!');

        } catch (\Throwable $th) {

            return back()->with('error', $th->getMessage());
        }
    }

    public function show(Role $role)
    {
        $permissions = Permission::all();
        $pers = PerName::all();

        return view('admin.pages.roles.show', compact('permissions', 'role', 'pers'));
    }

    public function edit(Role $role)
    {
        return view('admin.pages.roles.edit', compact('role'));
    }

    function updatePermissions(Request $request, $roleId) {

        try {

            $Arrypermissions = $request->permissions;
            $role = Role::where('id', '=', $roleId)->first();
            $rolePermissions = $role->permissions;

            foreach ($rolePermissions as $key => $rolePermission) {
                $role->revokePermissionTo($rolePermission->name);
            }

            foreach ($Arrypermissions as $key => $pers) {
                foreach ($Arrypermissions[$key] as $permission) {
                    $role->givePermissionTo($permission);
                }
            }

            return back()->with('success', 'les permissions de ce role '. $role->name . ' ont bien modifier!!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());

        }
    }

    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);

            $role->update(['name' => $request->name]);

            return back()->with('success', 'Rôle mis à jour avec succès !!');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());

        }
    }

    public function destroy(Role $role)
    {
        try {

            $role->delete();

            return back()->with('success', 'Rôle supprimé avec succès !');

        } catch (\Throwable $th) {

            return back()->with('error', $th->getMessage());
        }
    }
}
