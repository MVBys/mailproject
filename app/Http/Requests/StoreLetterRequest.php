<?php

namespace App\Http\Requests;

use App\Models\Letter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLetterRequest extends FormRequest
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
            'recipient' => [
                'required',
                'array',
            ],
            'recipient*' => [
                'email',
            ],
            'subject_letter' => [
                'required',
                'string',
                'max:10000'
            ],
            'img_token' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Letter::class, 'img_token')
            ],

        ];
    }
}
