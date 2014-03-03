<?php

namespace Flikore\Validator\Validators
{

    /**
     * Validates that a value is not empty. An empty value is null, empty string or empty array.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class NotEmptyValidator extends \Flikore\Validator\Validator
    {

        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must not be empty.';

        /**
         * Executes the real validation so it can be reused.
         * @param mixed $value The value to validate.
         * @return boolean Whether the value pass the validation.
         */
        protected function doValidate($value)
        {
            return !($value === null || $value === '' || (is_array($value) && empty($value)));
        }

    }

}