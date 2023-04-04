<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token){
            return response()->json(['error'=> 'UNAUTHORIZED'],Response::HTTP_UNAUTHORIZED);
        }
       /** @var User $user */
        $user = User::query()->where('id', function ($query) use ($token) {
            $query->select('tokenable_id')->from('personal_access_tokens')
                ->where('token', $token)
                ->where('expires_at','>', now());
        })->first();

        if (!$user){
            return response()->json(['error'=> 'UNAUTHORIZED'],Response::HTTP_UNAUTHORIZED);
        }
        Auth::setUser($user);
        return $next($request);
    }
}
