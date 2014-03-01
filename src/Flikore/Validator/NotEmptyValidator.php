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
         * @param string $key The key name of this value, if any.
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