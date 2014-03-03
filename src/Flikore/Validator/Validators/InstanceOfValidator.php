<?php

namespace Flikore\Validator\Validators
{

    /**
     * Validates that the value is an instance of a certain class.
     * 
     * @customKey <i>%class%</i> The name of the valid class.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class InstanceOfValidator extends \Flikore\Validator\Validator
    {

        /**
         * The class which the value must be instance of.
         * @var mixed The class which the value must be instance of.
         */
        protected $class;

        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must be an instance of %class%.';

        /**
         * Creates a new Instance Of Validator.
         * @param mixed $class The class which the value must be instance of.
         */
        public function __construct($class)
        {
            if (!(is_object($class)) && (!class_exists($class)))
            {
                throw new \InvalidArgumentException(sprintf('The class "%s" does not exist.', $class));
            }

            $this->class = $class;

            $this->addKeyValue('class', is_object($class) ? get_class($class) : $class);
        }

        /**
         * Executes the real validation so it can be reused.
         * @param mixed $value The value to validate.
         * @return boolean Whether the value pass the validation.
         */
        protected function doValidate($value)
        {
            // ignore empty values
            if (is_null($value) || $value === '')
            {
                return true;
            }
            return ($value instanceof $this->class);
        }

    }

}