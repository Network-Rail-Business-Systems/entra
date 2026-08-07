<?php

namespace NetworkRailBusinessSystems\Entra\FormRequests;

use Illuminate\Foundation\Http\FormRequest;
use NetworkRailBusinessSystems\Entra\Rules\EntraStateMatches;

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
