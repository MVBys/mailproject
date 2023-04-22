<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends AbstractBaseController
{
    public function setProStatus(Request $request): JsonResponse
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email')
            ]
        ]);
        $result = User::query()->where('email', $request['email'])->update([
            'pro_status' => now(),
        ]);

        return response()->json(['result' => !!$result]);
    }

    public function removeProStatus(Request $request): JsonResponse
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email')
            ]
        ]);
        $result = User::query()->where('email', $request['email'])->update([
            'pro_status' => null,
        ]);

        return response()->json(['result' => !!$result]);
    }

    public function authorized(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function destroy(): JsonResponse
    {
        $user = auth()->user();
        $result = $user->delete();
        return response()->json(['result' => !!$result]);
    }
}
