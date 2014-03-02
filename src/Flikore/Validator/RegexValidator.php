<?php

namespace Flikore\Validator
{

    /**
     * Validates if a string matches a given regular expression
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class RegexValidator extends Validator
    {

        /**
         * The regex to match.
         * @var string The regex to match.
         */
        protected $regex;

        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = 'The %key% must match the regular expression "%regex%".';

        /**
         * Creates a new Regex Validator.
         * @param string $regex The regex to match.
         */
        public function __construct($regex)
        {
            $test = @preg_match($regex, 'test');
            if ($test === false)
            {
                throw new \InvalidArgumentException(sprintf('"%s" is not a valid regular expression', $regex));
            }

            $this->regex = $regex;

            $this->addKeyValue('regex', $regex);
        }

        /**
         * Executes the real validation so it can be reused.
         * @param mixed $value The value to validate.
         * @return boolean Whether the value pass the validation.
         */
        protected function doValidate($value)
        {
            // ignore empty values
            if (empty($value))
            {
                return true;
            }
            return (bool)(preg_match($this->regex, $value));
        }

    }

}