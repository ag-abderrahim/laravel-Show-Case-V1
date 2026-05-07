<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth');
    //     $this->middleware('role_or_permission:super admin|admin|show users', ['only' => ['index']]);
    //     $this->middleware('role_or_permission:super admin|admin|create user', ['only' => ['store', 'create']]);
    //     $this->middleware('role_or_permission:super admin|admin|edit user', ['only' => ['edit', 'update']]);
    //     $this->middleware('role_or_permission:super admin|admin|delete user', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.pages.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required',
                // 'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|',
            ]);

            $role = Role::where('id', $request->role)->first();

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->syncRoles($role);

            return back()->with('success', 'Utilisateur bien créé');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.pages.users.edit', compact('user', 'roles'));
    }

    public function toggleActive(User $user) {
        try {
            // $user = User::where('id', $user)->first();
            $newStatus = !$user->is_active;

            $user->update([
                'is_active' => $newStatus
            ]);

            return back()->with('success', $newStatus
                ? 'Utilisateur activé'
                : 'Utilisateur désactivé');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function toggleVerify(User $user) {
        try {

            $isVerified = !$user->email_verified;

            $user->update([
                'email_verified' => $isVerified,
                'email_verified_at' => $isVerified ? now() : null,
            ]);

            return back()->with('success', $isVerified
                ? 'Email vérifié'
                : 'Email non vérifié');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required',
            ]);

            $role = Role::where('id', $request->role)->first();

            // Update user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $user->syncRoles($role);

            return back()->with('success', 'Utilisateur mis à jour');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {

            // ✅ Delete user from database
            $user->delete();

            return back()->with('success', 'Utilisateur supprimé');

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
