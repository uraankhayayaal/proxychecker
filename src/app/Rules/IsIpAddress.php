<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsIpAddress implements ValidationRule
{
    const IP_PATTERN = '/^\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?):\d{1,5}\b$/';

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $singleSpace = preg_replace('!\s+!', ' ', $value);
        $addresses = explode(" ", $singleSpace);

        $error = false;

        foreach ($addresses as $address)
        {
            if (!preg_match(self::IP_PATTERN, $address))
            {
                $error = true;
                break;
            }
        }

        if ($error)
        {
            $fail("Ошибки в форматах адресов прокси в :attribute: $address");
        }
    }
}
