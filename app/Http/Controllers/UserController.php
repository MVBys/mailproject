<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
}