<?php

namespace Flikore\Validator\Validators
{

    /**
     * Validates that a number is equal or greater than a given value.
     *
     * @customKey <i>%min%</i> The minimum valid value.
     * 
     * @author George Marques <george at georgemarques.com.br>
     */
    class MinValueValidator extends \Flikore\Validator\Validator
    {
        /**
         * The minimum valid value.
         * @var int The minimum valid value.
         */
        protected $min;

        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must be equal or greater than %min%.';

        /**
         * Creates a new Min Value Validator.
         * @param int $min The minimum valid value.
         */
        public function __construct($min)
        {
            if (!is_int($min))
            {
                throw new \InvalidArgumentException('The minimum must be a valid integer');
            }

            $this->min = $min;

            $this->addKeyValue('min', $min);
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
            return ($value >= $this->min);
        }

    }

}