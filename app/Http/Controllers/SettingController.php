<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSettingsUpdateRequest;
use App\Http\Resources\SettingCollection;
use App\Http\Resources\SettingDefaultCollection;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class SettingController extends Controller
{
    public function getDefaultList(): SettingDefaultCollection
    {
        return new SettingDefaultCollection(Setting::all());
    }

    public function getUserSetting(): SettingCollection
    {
        /** @var User $user */
        $user = auth()->user();
        return new SettingCollection($user->settings);
    }

    public function updateUserSettings(UserSettingsUpdateRequest $request): JsonResponse
    {
        $settings = $request->only(['emails_opened', 'not_opened_24', 'no_reply_72', 'daily_report', 'many_opened']);

        /** @var User $user */
        $user = auth()->user();
        foreach ($settings as $key => $value) {
            $user->settings()->where('name', $key)->update([
                'enabled' => $value
            ]);
        }

        return response()->json(['result' => true]);
    }

}
