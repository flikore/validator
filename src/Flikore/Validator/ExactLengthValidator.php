<?php

namespace Flikore\Validator
{

    /**
     * Validates that the number of characters of the value is exactly a given amount.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class ExactLengthValidator extends Validator
    {
        /**
         * The exact valid length.
         * @var int The exact valid length.
         */
        protected $length;

        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must have exactly %length% characters.';

        /**
         * Creates a new Exact Length Validator.
         * @param int $length The exact valid length.
         */
        public function __construct($length)
        {
            if (!is_int($length))
            {
                throw new \InvalidArgumentException('The length must be a valid integer');
            }

            $this->length = $length;

            $this->addKeyValue('length', $length);
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
            return (strlen($value) == $this->length);
        }

    }

}