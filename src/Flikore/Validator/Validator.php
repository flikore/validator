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
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = '';
        
        /**
         * Stores the values to change in the template.
         * @var array Stores the values to change in the template.
         */
        protected $values = array(
            'key' => 'value'
        );

        /**
         * Checks if the value passes the validation test.
         * @param mixed $value The value to test.
         * @return boolean Whether it passes the test or not.
         */
        public function validate($value)
        {
            try
            {
                $this->assert($value);
            }
            catch (Exception\ValidatorException $e)
            {
                return false;
            }
            return true;
        }

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
        public function getErrorMessage()
        {
            return $this->applyTemplate();
        }


        /**
         * Sets the error message for this validator.
         * @param string $message The message.
         */
        public function setErrorMessage($message)
        {
            $this->message = $message;
        }
        
        /**
         * Adds a new key-value pair to be replaced by the templating engine.
         * This does not check if it's replacing a specific validator value.
         * @param string $key The key to replace (in the template as "%key%")
         * @param string $value The value to be inserted instead of the key.
         */
        public function addKeyValue($key, $value)
        {
            $this->values[$key] = (string) $value;
        }

        /**
         * Applies the template message to a formed one.
         * @return string The formed message.
         */
        protected function applyTemplate()
        {
            $message = dgettext('Flikore.Validator', $this->message);
            foreach ($this->values as $key => $value)
            {
                $message = str_replace("%$key%", dgettext('Flikore.Validator', $value), $message);
            }
            return $message;
        }
    }

}