<?php

namespace Flikore\Validator
{

    /**
     * Combines two or more validator objects into one. This validates with all
     * the inserted validators and stops at the first error, return the message
     * of the validator that went wrong.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class ValidationCombo extends Validator
    {
        /**
         * The error message for this validator.
         * @var string The error message for this validator.
         */
        protected $message = null;

        /**
         * A collection of all validators.
         * @var Validator[] A collection of all validators.
         */
        protected $validators;
        
        /**
         * Creates a Validation Combo.
         */
        public function __construct()
        {
            $this->validators = new \SplDoublyLinkedList();
        }

        /**
         * Adds a new validator to the combo.
         * @param Validator $validator The validator to add.
         */
        public function addValidator(Validator $validator)
        {
            $validator->addKeyValue('key', $this->values['key']);
            $this->validators->push($validator);
        }
        
        /**
         * Executes the real validation so it can be reused.
         * @param mixed $value The value to validate.
         * @return boolean Whether the value pass the validation.
         */
        protected function doValidate($value)
        {
            foreach ($this->validators as $rule)
            {
                if(!$rule->validate($value))
                {
                    $this->setErrorMessage($this->message === null ? $rule->getErrorMessage() : $this->message);
                    return false;
                }
            }
            return true;
        }
        
        /**
         * Adds a new key-value pair to be replaced by the templating engine.
         * This does not check if it's replacing a specific validator value.
         * @param string $key The key to replace (in the template as "%key%")
         * @param string $value The value to be inserted instead of the key.
         */
        public function addKeyValue($key, $value)
        {
            foreach ($this->validators as $v)
            {
                $v->addKeyValue($key, $value);
            }
        }
    }

}