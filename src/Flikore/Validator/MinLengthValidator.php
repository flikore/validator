<?php

namespace Flikore\Validator
{

    /**
     * Validates that the number of characters of value is between a certain range.
     * This can be used to check only the maximum (if the minimun is null) or vice-versa.
     * To check for an exact length, set the minimum and the maximum to such exact length.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class MinLengthValidator extends Validator
    {
        /**
         * The minimum valid length.
         * @var int The minimum valid length.
         */
        protected $min;

        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must have at least %min% characters.';

        /**
         * Creates a new Min Length Validator.
         * @param int $min The minimum valid length.
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
            if(empty($value))
            {
                return true;
            }
            return (strlen($value) >= $this->min);
        }

    }

}