<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
// use Illuminate\Http\Request;

class ADashboardController extends Controller
{
    public function dashbaord() {
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::all();
        
        return view('admin.pages.dashboard', compact('roles', 'permissions', 'users'));
    }
}
