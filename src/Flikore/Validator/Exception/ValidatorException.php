<?php

namespace Flikore\Validator\Exception
{

    /**
     * An exception thrown if there are any validation error.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class ValidatorException extends \Exception
    {
        /**
         * The inner exceptions.
         * @var ValidatorException[] The inner exceptions.
         */
        protected $errors;


        /**
         * Gets the inner exceptions from a set of validators.
         * @return ValidatorException[] The set of exceptions.
         */
        public function getErrors()
        {
            return $this->errors;
        }
        
        /**
         * Gets the inner exception for a specific key.
         * @param string $key The key to get.
         * @return ValidatorException The exception of that key or null if there's none.
         */
        public function getEror($key)
        {
            return isset($this->errors[$key]) ? $this->errors[$key] : null;
        }
        
        /**
         * Sets the inner exceptions for this exception.
         * @param array $errors The set of exceptions.
         */
        public function setErrors($errors)
        {
            $this->errors = $errors;
        }
        
        /**
         * Sets the inner exceptions for a specific key.
         * @param ValidatorException $error The exception.
         * @param string $key The key name.
         */
        public function setError($error, $key)
        {
            $this->errors[$key] = $error;
        }
    }

}