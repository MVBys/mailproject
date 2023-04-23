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
        $prepareSettings = [];
        foreach ($request->get('settings') as $setting) {
            $prepareSettings[$setting['setting_id']] = ['enabled' => $setting['enabled']];
        }

        /** @var User $user */
        $user = auth()->user();
        $user->settings()->syncWithoutDetaching($prepareSettings);

        return response()->json(['result' => true]);
    }

}
