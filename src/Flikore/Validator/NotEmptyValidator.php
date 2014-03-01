<?php

namespace Flikore\Validator
{

    /**
     * Validates that a value is not empty. An empty value is null, empty string or empty array.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class NotEmptyValidator extends Validator
    {
        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must not be empty.';
        
        /**
         * Checks if the value passes the validation test and throws
         * an exception if not.
         * @param mixed $value The value to test.
         * @throws Exception\ValidatorException
         */
        public function assert($value)
        {
            if($value === null || $value === '' || (is_array($value) && empty($value)))
            {
                throw new Exception\ValidatorException($this->getErrorMessage());
            }
        }
    }

}