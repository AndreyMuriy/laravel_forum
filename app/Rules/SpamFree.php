<?php

namespace App\Rules;

use App\Inspections\Spam;
use Exception;

class SpamFree
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            return !resolve(Spam::class)->detect($value);
        } catch (Exception $exception) {
            return false;
        }
    }
}
