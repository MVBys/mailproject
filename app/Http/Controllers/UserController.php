<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
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
        /** @var User $user */
        $user = User::query()->where('email', $request['email'])->first();
        $result = $user->update([
            'pro_status' => null,
        ]);
        $user->settings()->where('is_pro', true)->update([
            'enabled' => false,
        ]);

        return response()->json(['result' => true]);
    }

    public function authorized(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function destroy(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $result = $user->delete();
        return response()->json(['result' => !!$result]);
    }
}
