<?php

namespace NetworkRailBusinessSystems\Entra\FormRequests;

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
            // TODO
        ];
    }

    public function messages(): array
    {
        return [
            // TODO
        ];
    }
}
