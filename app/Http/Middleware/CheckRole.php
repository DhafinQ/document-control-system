<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = Auth::user();

        // Pastikan pengguna autentikasi memiliki peran yang sesuai
        if ($user && ($user->isRole('Admin') || $user->isRole($role))) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
