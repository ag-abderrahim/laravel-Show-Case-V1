<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PerName;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth');
    //     $this->middleware('role_or_permission:super admin|admin|show permissions', ['only' => ['index']]);
    //     $this->middleware('role_or_permission:super admin|admin|create permission', ['only' => ['store', 'create']]);
    //     $this->middleware('role_or_permission:super admin|admin|edit permission', ['only' => ['edit', 'update']]);
    //     $this->middleware('role_or_permission:super admin|admin|delete permission', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $permissions = Permission::all();
        return view('admin.pages.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.pages.permissions.create');
    }

    public function store(Request $request)
    {
        try {
            $opts = [
                'create',
                'show',
                'show',
                'edit',
                'delete',
            ];

            $request->validate([
                'name' => 'required',
            ]);

            PerName::create([
                'name' => $request->name,
            ]);

            foreach ($opts as $key => $opt) {
                if ($key == 2) {
                    Permission::create([
                        'name' => $opt . ' ' . $request->name .'s'
                    ]);

                } else {
                    Permission::create([
                        'name' => $opt . ' ' . $request->name
                    ]);

                }
            }

            return back()->with('success', 'Permission a bien créer');

        } catch (\Throwable $th) {
            return back()->with('warning', $th->getMessage());
        }
    }

    public function edit(Permission $permission)
    {
        return view('admin.pages.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $permission->update($request->all());

            return back()->with('success', 'Permission a bien modifier');

        } catch (\Throwable $th) {
            return back()->with('warning', $th->getMessage());
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();

            return back()->with('success', 'Permission a bien supprimé');

        } catch (\Throwable $th) {
            return back()->with('warning', $th->getMessage());
        }
    }
}
