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
    class MaxLengthValidator extends Validator
    {
        /**
         * The maximum valid length.
         * @var int The maximum valid length.
         */
        protected $max;

        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must have at most %max% characters.';

        /**
         * Creates a new Max Length Validator.
         * @param int $max The maximum valid length.
         */
        public function __construct($max)
        {
            if (!is_int($max))
            {
                throw new \InvalidArgumentException('The maximum must be a valid integer');
            }

            $this->max = $max;

            $this->addKeyValue('max', $max);
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
            return (strlen($value) <= $this->max);
        }

    }

}