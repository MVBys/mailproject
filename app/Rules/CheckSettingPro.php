<?php

namespace App\Rules;

use App\Models\Setting;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckSettingPro implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var Setting $setting */
        $setting = Setting::query()->where('name', $attribute)->first();
        /** @var User $user */
        $user = auth()->user();
        if ($value && $setting->is_pro && !$user->isPro()) {
            $fail('The :attribute only available for pro version.');
        }
    }
}
