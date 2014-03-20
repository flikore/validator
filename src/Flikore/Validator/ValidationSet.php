<?php

/**
 * The MIT License
 *
 * Copyright 2014 George Marques <george at georgemarques.com.br>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Flikore\Validator;

use Flikore\Validator\Exception\ValidatorException;

/**
 * A set of validation rules to be checked at the same input set.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.1
 * @since 0.1
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class ValidationSet implements Interfaces\IValidator
{

    /**
     * An array of validation objects.
     * @var Validator[][] An array of validation objects.
     */
    protected $validators;

    /**
     * Stores the key-value pairs for the inner validators.
     * @var array Stores the key-value pairs for the inner validators.
     */
    protected $values = array();

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
        if ($label === null)
        {
            $label = $name;
        }
        $rule->addKeyValue('key', $label);
        $this->validators[$name][] = $rule;
        $this->updateSingleKeyValue($rule);
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
     * Gets the set of rules prepared for a given key.
     * 
     * @param string $key The key to get.
     * @return array The array with the rules (may be emtpy).
     */
    public function getRulesFor($key)
    {
        return isset($this->validators[$key]) ? $this->validators[$key] : array();
    }
    
    /**
     * Gets all the rules in this set.
     * 
     * @return array The collection of rules by fields.
     */
    public function getAllRules()
    {
        return $this->validators;
    }

    /**
     * Checks if the object or array passes all the validation tests.
     * 
     * @param mixed $object The object or array to test.
     * @param array $fields A list of fields to check, ignoring the others.
     * @return boolean Whether it passes the tests or not.
     * @throws \InvalidArgumentException If the fields parameter is not string nor array.
     * @throws \OutOfBoundsException If there's a rule for a key that is not set.
     */
    public function validate($object, $fields = null)
    {
        $fields = $this->getFields($fields);

        foreach ($fields as $att)
        {
            // This ignores the input fields that haven't any rules.
            if(! isset($this->validators[$att]))
            {
                continue;
            }
            
            $rules = $this->validators[$att];            
            $value = $this->getKeyValue($object, $att);

            foreach ($rules as $rule)
            {
                if ($rule instanceof ValidationValue)
                {
                    $rule = $this->getRealValidator($rule, $object);
                }
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
     * 
     * @param mixed $object The object or array to test.
     * @param array $fields A list of fields to check, ignoring the others.
     * @throws ValidatorException If there's a validation error.
     * @throws \OutOfBoundsException If there's a rule for a key that is not set.
     * @throws \InvalidArgumentException If the fields parameter is not string nor array.
     */
    public function assert($object, $fields = null)
    {
        $fields = $this->getFields($fields);

        $exceptions = array();
        foreach ($fields as $att)
        {
            // This ignores the input fields that haven't any rules.
            if(! isset($this->validators[$att]))
            {
                continue;
            }
            
            $value = $this->getKeyValue($object, $att);
            $rules = $this->validators[$att];
            
            foreach ($rules as $rule)
            {
                if ($rule instanceof ValidationValue)
                {
                    $rule = $this->getRealValidator($rule, $object);
                }
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
     * Adds a new key-value pair to be replaced by the templating engine.
     * This does not check if it's replacing a specific validator value.
     * 
     * @param string $key The key to replace (in the template as "%key%")
     * @param string $value The value to be inserted instead of the key.
     */
    public function addKeyValue($key, $value)
    {
        if (is_object($value) && !method_exists($value, '__toString'))
        {
            $value = get_class($value);
        }
        $this->values[$key] = (string) $value;
        $this->updateKeyValues();
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
                    throw new \OutOfBoundsException(sprintf(Intl\GetText::_d('Flikore.Validator', 'The key %s does not exist.'), $key));
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
                throw new \OutOfBoundsException(sprintf(Intl\GetText::_d('Flikore.Validator', 'The property %s does not exist.'), $key), 0, $e);
            }
            $prop->setAccessible(true);
            return $prop->getValue($object);
        }
        throw new \InvalidArgumentException('The value to validate must be an array or an object.');
    }

    /**
     * Generates a validator object based on a ValidationValue.
     * 
     * @param ValidationValue $validationValue The value to use as generator.
     * @param mixed $object The object or array being validated.
     */
    protected function getRealValidator($validationValue, $object)
    {
        $needed = $validationValue->getFields();
        $values = array();
        foreach ($needed as $key)
        {
            $values[$key] = $this->getKeyValue($object, $key);
        }
        return $validationValue->createRule($values);
    }

    /**
     * Updates the inner key-value pairs to reflect this object's values.
     */
    protected function updateKeyValues()
    {
        if (!empty($this->validators))
        {
            foreach ($this->validators as $rules)
            {
                foreach ($rules as $rule)
                {
                    $this->updateSingleKeyValue($rule);
                }
            }
        }
    }

    /**
     * Updates a single validator to have the same key-values added to the set.
     * 
     * @param Interfaces\IValidator $rule The rule to update
     */
    protected function updateSingleKeyValue($rule)
    {
        foreach ($this->values as $key => $value)
        {
            $rule->addKeyValue($key, $value);
        }
    }
    
    /**
     * Gets the fields from the input. As function to avoid repeat on validate and assert.
     * 
     * @param string|array $fields The input fields.
     * @throws \InvalidArgumentException If the fields parameter is not string nor array.
     */
    protected function getFields($fields)
    {
        if ($fields === null)
        {
            $fields = array_keys($this->validators);
        }
        elseif (is_string($fields) || is_int($fields))
        {
            $fields = array($fields);
        }
        elseif (!is_array($fields))
        {
            throw new \InvalidArgumentException(sprintf(
                    Intl\GetText::_d('Flikore.Validator', 'The argument "%s" must be either %s, %s or %s.'), 
                    'fields', Intl\GetText::_d('Flikore.Validator','a string'), Intl\GetText::_d('Flikore.Validator','an array'), Intl\GetText::_d('Flikore.Validator','an integer')));
        }
        return $fields;
    }

}
