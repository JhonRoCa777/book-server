<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::find($request->attributes->get('auth_user_id'));

        if (!$user || $user->credential->role !== Role::ADMIN)
            return response('',403);

        return $next($request);
    }
}
