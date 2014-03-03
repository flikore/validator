<?php

namespace Flikore\Validator\Validators
{

    /**
     * Validates that a number is exactly a certain value.
     * 
     * @customKey <i>%value%</i> The exact valid value.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class ExactValueValidator extends \Flikore\Validator\Validator
    {
        /**
         * The exact valid value.
         * @var int The exact valid value.
         */
        protected $value;

        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must be exactly %value%.';

        /**
         * Creates a new Exact Value Validator.
         * @param int $value The exact valid value.
         */
        public function __construct($value)
        {
            if (!is_int($value))
            {
                throw new \InvalidArgumentException('The value must be a valid integer');
            }

            $this->value = $value;

            $this->addKeyValue('value', $value);
        }

        /**
         * Executes the real validation so it can be reused.
         * @param mixed $value The value to validate.
         * @return boolean Whether the value pass the validation.
         */
        protected function doValidate($value)
        {
            // ignore empty values
            if(is_null($value) || $value === '')
            {
                return true;
            }
            return ($value == $this->value);
        }

    }

}