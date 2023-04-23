<?php

namespace App\Http\Requests;

use App\Models\Letter;
use App\Models\Setting;
use App\Rules\CheckSettingPro;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserSettingsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'settings' => [
                'required',
                'array',
                'max:' . Setting::query()->count(),
            ],
            'settings.*' =>[
                'array',
            ],
            'settings.*.setting_id' => [
                'required',
                'integer',
                new CheckSettingPro(),
            ],
            'settings.*.enabled' => [
                'required',
                'bool',
            ]
        ];
    }
}
