<?php

namespace Flikore\Validator
{

    /**
     * Validates that the number of characters of the value is between a certain range.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class LengthBetweenValidator extends Validator
    {

        /**
         * The minimum valid length.
         * @var int The minimum valid length.
         */
        protected $min;

        /**
         * The maximum valid length.
         * @var int The maximum valid length.
         */
        protected $max;

        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must have between %min% and %max% characters.';

        /**
         * Creates a new Length Between Validator.
         * @param int $min The minimum valid length.
         * @param int $max The maximum valid length.
         */
        public function __construct($min, $max)
        {
            if (!is_int($min))
            {
                throw new \InvalidArgumentException('The minimum must be a valid integer');
            }
            if (!is_int($max))
            {
                throw new \InvalidArgumentException('The maximum must be a valid integer');
            }

            $this->min = $min;
            $this->max = $max;

            $this->addKeyValue('min', $min);
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
            return (strlen($value) >= $this->min and strlen($value) <= $this->max);
        }

    }

}