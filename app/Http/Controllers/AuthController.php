<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private readonly string $urlGetUsers;

    public function __construct()
    {
        $this->urlGetUsers = 'https://gmail.googleapis.com/gmail/v1/users/';
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'goo_token' => 'required',
        ]);

        $gooResponse = Http::withToken($request->get('goo_token'))->get($this->urlGetUsers)->collect();

        if ($gooResponse->get('emailAddress') != $request->get('email')) {
          return response()->json(['error'=> 'mismatch token and mail'],Response::HTTP_NOT_ACCEPTABLE);
        }
        /** @var User $user */
        $user = User::firstOrCreate(['email' => $request->get('email')]);

        $token = $user->createToken($request->get('email'), expiresAt: now()->addDay())->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
