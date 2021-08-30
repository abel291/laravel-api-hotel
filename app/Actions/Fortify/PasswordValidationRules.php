<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected $length = 6;
    protected function passwordRules()
    {
        return ['required', 'string', (new Password)->length(6), 'confirmed'];
    }
}
