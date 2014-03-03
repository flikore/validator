<?php

namespace Flikore\Validator
{

    use Flikore\Validator\Exception\ValidatorException;

    /**
     * A set of validation rules to be checked at the same input set.
     *
     * @author George Marques <george at georgemarques.com.br>
     */
    class ValidationSet
    {

        /**
         * An array of validation objects.
         * @var Validator[][] An array of validation objects.
         */
        protected $validators;

        /**
         * Creates a new validation set.
         * @param array $rules An array of rules with the key being the name of the attribute
         *                     and the value being a Validator instance.
         * @param array $labels The association of name => label to show in error messages.
         */
        public function __construct($rules = array(), $labels = array())
        {
            foreach ($rules as $name => $rule)
            {
                $label = isset($labels[$name]) ? $labels[$name] : null;
                if (is_array($rule))
                {
                    $this->addRules($name, $rule, $label);
                }
                else
                {
                    $this->addRule($name, $rule, $label);
                }
            }
        }

        /**
         * Adds a new rule for a given property or key name.
         * @param string $name The name of the key or property.
         * @param Validator $rule The validation rule.
         * @param string $label The label to be shown in the error message (intead of the name).
         */
        public function addRule($name, $rule, $label = null)
        {
            if($label === null)
            {
                $label = $name;
            }
            $rule->addKeyValue('key', $label);
            $this->validators[$name][] = $rule;
        }

        /**
         * Adds a new set rules for a given property or key name.
         * @param string $name The name of the key or property.
         * @param Validator[] $rules The array of rules.
         * @param string $label The label to be shown in the error message (intead of the name).
         */
        public function addRules($name, $rules, $label = null)
        {
            foreach ($rules as $rule)
            {
                $this->addRule($name, $rule, $label);
            }
        }

        /**
         * Checks if the object or array passes all the validation tests.
         * @param mixed $object The object or array to test.
         * @return boolean Whether it passes the tests or not.
         */
        public function validate($object)
        {
            foreach ($this->validators as $att => $rules)
            {
                $value = $this->getKeyValue($object, $att);
                foreach ($rules as $rule)
                {
                    if (!$rule->validate($value))
                    {
                        return false;
                    }
                }
            }
            return true;
        }

        /**
         * Tests whether the given object or array pass all the given rules.
         * @param mixed $object The object or array to test.
         */
        public function assert($object)
        {
            $exceptions = array();
            foreach ($this->validators as $att => $rules)
            {
                $value = $this->getKeyValue($object, $att);
                foreach ($rules as $rule)
                {
                    try
                    {
                        $rule->assert($value, $att);
                    }
                    catch (ValidatorException $e)
                    {
                        $exceptions[$att] = $e;
                        break;
                    }
                }
            }
            if (!empty($exceptions))
            {
                $e = new ValidatorException();
                $e->setErrors($exceptions);
                throw $e;
            }
        }

        /**
         * Gets a value for a given key in an object or array.
         * @param mixed $object The object or array.
         * @param string $key The name of the key or property.
         * @return mixed The value.
         * @throws \OutOfBoundsException
         */
        protected function getKeyValue($object, $key)
        {
            if (is_array($object) || ($object instanceof \ArrayAccess))
            {
                if (!isset($object[$key]))
                {
                    if (!($object instanceof \ArrayAccess))
                    {
                        throw new \OutOfBoundsException(sprintf(dgettext('Flikore.Validator', 'The key %s does not exist.'), $key));
                    }
                }
                else
                {
                    return $object[$key];
                }
            }

            if (is_object($object))
            {
                try
                {
                    $prop = new \ReflectionProperty($object, $key);
                }
                catch (\ReflectionException $e)
                {
                    throw new \OutOfBoundsException(sprintf(dgettext('Flikore.Validator', 'The property %s does not exist.'), $key), 0, $e);
                }
                $prop->setAccessible(true);
                return $prop->getValue($object);
            }
        }

    }

}