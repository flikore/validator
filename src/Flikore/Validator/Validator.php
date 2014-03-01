<?php

namespace Flikore\Validator
{

    /**
     * The base for validation classes.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    abstract class Validator
    {
        /**
         * Checks if the value passes the validation test.
         * @param mixed $value The value to test.
         * @return boolean Whether it passes the test or not.
         */
        public abstract function validate($value);
        
        /**
         * Checks if the value passes the validation test and throws
         * an exception if not.
         * @param mixed $value The value to test.
         * @throws Exception\ValidatorException
         */
        public abstract function assert($value);
        
        /**
         * Gets the error message for this validation.
         * This should work whether or not there was a test before.
         * @return string The error message.
         */
        public abstract function getErrorMessage();
    }

}