<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
  {
        $user = Auth::user();

        // Ambil nama role dari user
        $roles = $user->roles->pluck('name')->join(', '); // Menggabungkan nama role dengan koma jika lebih dari satu

        return view('profile.index', compact('user', 'roles'));
    }
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
}
