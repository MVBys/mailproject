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
            'emails_opened' => [
                'required',
                'bool',
                new CheckSettingPro()
            ],
            'not_opened_24' => [
                'required',
                'bool',
                new CheckSettingPro()
            ],
            'no_reply_72' => [
                'required',
                'bool',
                new CheckSettingPro()
            ],
            'daily_report' => [
                'required',
                'bool',
                new CheckSettingPro()
            ],
            'many_opened' => [
                'required',
                'bool',
                new CheckSettingPro()
            ],
        ];
    }
}
