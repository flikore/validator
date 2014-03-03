<?php

namespace Flikore\Validator
{

    /**
     * Validates that the number of characters of the value is at least a given amount.
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
            if(is_null($value) || $value === '')
            {
                return true;
            }
            return (strlen($value) >= $this->min);
        }

    }

}