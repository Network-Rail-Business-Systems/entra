<?php

namespace NetworkRailBusinessSystems\Entra\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;

class UserExistsInEntra implements ValidationRule
{
    public string $formattedField = '';

    public function __construct(public string $field = 'mail')
    {
        $this->formattedField = match ($field) {
            'businessPhones' => 'phone number',
            'displayName' => 'first name',
            'givenName' => 'full name',
            'id',
            'jobTitle' => 'job title',
            'mail' => 'e-mail',
            'mobilePhone' => 'mobile number',
            'officeLocation' => 'office name',
            'surname' => 'surname',
            'userPrincipalName' => 'username',
            default => $field,
        };
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (EntraUser::find($value, $this->field) === null) {
            $fail("Enter the $this->formattedField of a person with a Network Rail account");
        }
    }
}
