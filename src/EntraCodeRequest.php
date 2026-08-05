<?php

namespace NetworkRailBusinessSystems\Entra;

use Illuminate\Foundation\Http\FormRequest;

class EntraCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
            ],
            'state' => [
                'required',
                'string',
                new EntraStateMatches(),
            ],
            'session_state' => [
                'required',
                'string',
            ],
        ];
    }
}
