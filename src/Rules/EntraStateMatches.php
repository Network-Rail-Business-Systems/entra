<?php

namespace NetworkRailBusinessSystems\Entra\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Entra;

class EntraStateMatches implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $state = Session::get(Entra::ENTRA_STATE);

        if (empty($state) === true) {
            $fail('Entra state is expired or missing');
            return;
        }

        if ($value !== $state) {
            $fail('Entra state does not match');
        }
    }
}
