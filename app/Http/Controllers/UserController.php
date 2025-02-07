<?php

namespace App\Http\Controllers;

use App\Events\NewCreatedUser;
use Illuminate\Http\Request;
use App\Models\User;
use Itstructure\LaRbac\Models\Role;

class UserController extends Controller
{
    // Menampilkan Formulir Create User
    public function create()
    {
        // Mendapatkan semua role yang tersedia dari RBAC
        $roles = Role::all();

        return view('vendor.rbac.users.create', compact('roles'));
    }

    // Menyimpan Data User Baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,id',
        ]);

        // Membuat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Menambahkan role ke user
        $user->roles()->attach($request->role);

        // Menambah Notifikasi ubah password pada new user
        event(new NewCreatedUser($user));

        return redirect()->route('list_users')->with('success', __('User created successfully.'));
    }
}
