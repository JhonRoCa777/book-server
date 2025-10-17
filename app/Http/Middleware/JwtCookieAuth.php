<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class JwtCookieAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie(env('JWT_NAME'));
        if (!$token)
            return response('',401);

        try {
            $payload = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (\Exception $e) {
            return response('',401);
        }

        $request->attributes->set('auth_user_id', $payload->sub);

        return $next($request);
    }
}
