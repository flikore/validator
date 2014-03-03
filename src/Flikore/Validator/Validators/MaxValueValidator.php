<?php

namespace Flikore\Validator\Validators
{

    /**
     * Validates that a number is equal or lesser than a given value.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class MaxValueValidator extends \Flikore\Validator\Validator
    {
        /**
         * The maximum valid value.
         * @var int The maximum valid value.
         */
        protected $max;

        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must be equal or lesser than %max%.';

        /**
         * Creates a new Max Value Validator.
         * @param int $max The maximum valid value.
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
            if(is_null($value) || $value === '')
            {
                return true;
            }
            return ($value <= $this->max);
        }

    }

}