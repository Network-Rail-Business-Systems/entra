<?php

namespace NetworkRailBusinessSystems\Entra\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserExistsInDatabase implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // TODO: Implement validate() method.
    }
}
