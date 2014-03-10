<?php

/*
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

/**
 * The base for validation classes.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.4.0
 * @since 0.1
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
abstract class Validator implements Interfaces\IValidator
{

    /**
     * The error message for this validator.
     * @var string The error message for this validator.
     */
    protected $message = '';

    /**
     * Stores the values to change in the template.
     * @var array Stores the values to change in the template.
     */
    protected $values = array(
        'key' => 'value'
    );

    /**
     * Checks if the value passes the validation test.
     * @param mixed $value The value to test.
     * @return boolean Whether it passes the test or not.
     */
    public function validate($value)
    {
        return $this->doValidate($value);
    }

    /**
     * Checks if the value passes the validation test and throws
     * an exception if not.
     * @param mixed $value The value to test.
     * @throws Exception\ValidatorException
     */
    public function assert($value)
    {
        if (!$this->doValidate($value))
        {
            throw new Exception\ValidatorException($this->getErrorMessage());
        }
    }

    /**
     * Gets the error message for this validation.
     * This should work whether or not there was a test before.
     * @return string The error message.
     */
    public function getErrorMessage()
    {
        return $this->applyTemplate();
    }

    /**
     * Sets the error message for this validator.
     * @param string $message The message.
     */
    public function setErrorMessage($message)
    {
        $this->message = $message;
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
        if(is_object($value) && !method_exists($value, '__toString'))
        {
            $value = get_class($value);
        }
        $this->values[$key] = (string) $value;
    }

    /**
     * Applies the template message to a formed one.
     * @return string The formed message.
     */
    protected function applyTemplate()
    {
        $message = dgettext('Flikore.Validator', $this->message);
        foreach ($this->values as $key => $value)
        {
            $message = str_replace("%$key%", dgettext('Flikore.Validator', $value), $message);
        }
        return $message;
    }

    /**
     * Executes the real validation so it can be reused.
     * @param mixed $value The value to validate.
     * @return boolean Whether the value pass the validation.
     */
    protected abstract function doValidate($value);
    
    /**
     * Checks if a value is considered empty, so the derived 
     * validators can have a standard.
     * 
     * @param mixed $value The value to check.
     * @return boolean Whether it is empty or not.
     */
    protected function isEmpty($value)
    {
        if (is_null($value) || $value === '')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
