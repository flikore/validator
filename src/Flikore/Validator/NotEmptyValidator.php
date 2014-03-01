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

        /**
         * Gets the error message for this validation.
         * This should work whether or not there was a test before.
         * @param string $key The name of the key which contains this value.
         * @return string The error message.
         */
        public function getErrorMessage($key = null)
        {
            if($key === null)
            {
                $key = 'value';
            }
            return sprintf(dgettext('Flikore.Validator', 'The %s must not be empty.'), $key);
        }

    }

}