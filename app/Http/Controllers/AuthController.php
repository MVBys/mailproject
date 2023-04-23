<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private readonly string $urlGetUser;

    public function __construct()
    {
        $this->urlGetUser = 'https://www.googleapis.com/oauth2/v3/userinfo';
    }

    public function loginUseGooToken(Request $request): JsonResponse
    {
        $request->validate([
            'goo_token' => 'required',
        ]);

        $gooResponse = Http::withToken($request->get('goo_token'))->get($this->urlGetUser)->collect();

        if (!$gooResponse->get('email')) {
            return response()->json(['error' => 'UNAUTHORIZED'], Response::HTTP_UNAUTHORIZED);
        }
        /** @var User $user */
        $user = User::query()->firstOrCreate(
            ['email' => $gooResponse->get('email')],
            [
                'name' => $gooResponse->get('name'),
                'email_verified_at' => now(),
                'password' => Hash::make($gooResponse->get('sub'))
            ]
        );

        $token = $user->createToken($gooResponse->get('email'))->plainTextToken;

        return response()->json([
            'token' => $token,
            'exp' => config('sanctum.expiration')
        ]);
    }

    public function loginUsePassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Login information is invalid.'
            ], 401);
        }
        $user = User::query()->where(['email' => $request->get('email')])->first();
        $token = $user->createToken($request->get('email'), expiresAt: now()->addDay())->plainTextToken;
        return response()->json([
            'token' => $token,
            'exp' => config('sanctum.expiration')
        ]);
    }
}
