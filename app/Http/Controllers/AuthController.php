<?php

namespace App\Http\Controllers;

use App\Http\Requests\CredentialRequest;
use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;

class AuthController extends Controller
{
    protected string $name;
    protected string $secret;
    protected int $ttl;

    public function __construct()
    {
        $this->secret = env('JWT_SECRET');
        $this->ttl = (int) env('JWT_TTL', 60);
        $this->name = env('JWT_NAME', 'auth_token');
    }

    public function login(CredentialRequest $request)
    {
        $credential = Credential::where('username', $request->username)->first();

        if (!$credential || !Hash::check($request->password, $credential->password)) {
            return response('',401);
        }

        $user = $credential->user;
        if (!$user) {
            return response('',404);
        }

        $now = time();
        $exp = $now + ($this->ttl * 60);

        $payload = [
            'sub' => $user->id,
            'iat' => $now,
            'exp' => $exp,
        ];

        $jwt = JWT::encode($payload, $this->secret, 'HS256');

        $cookie = cookie(
            name: $this->name,
            value: $jwt,
            minutes: $this->ttl,
            path: '/',
            domain: null,
            secure: config('app.env') === 'production',
            httpOnly: true,
            raw: false,
            sameSite: 'lax'
        );

        return response('',200)->withCookie($cookie);
    }

    public function logout()
    {
        $cookie = cookie()->forget($this->name);
        return response('',200)->withCookie($cookie);
    }

    public function me(Request $request)
    {
        $user = User::find($request->attributes->get('auth_user_id'));

        if (!$user)
            return response('',404);

        return response()->json([
            'user' => [
                "id" => $user->id,
                "document" => $user->document,
                "names" => $user->names,
                "last_names" => $user->last_names,
            ],
            'role' => $user->credential->role]);
    }
}
