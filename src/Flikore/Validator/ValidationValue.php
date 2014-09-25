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

use Flikore\Validator\Interfaces\IValidator;

/**
 * This class can be used as a validation rule in a set to use the fields from the object
 * being validate as an input to the constructor of a validator. This delegates the proper
 * construction of the validation until there are an object to validate.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.2
 * @since 0.4.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class ValidationValue
{

    /**
     * The validator to build.
     * @var string The validator to build.
     */
    protected $validator;

    /**
     * The arguments to the validator constructor.
     * @var array The arguments to the validator constructor.
     */
    protected $args;

    /**
     * A list of fields to fecth from the validated object.
     * @var array A list of fields to fecth from the validated object.
     */
    protected $fields = array();

    /**
     * The error message to the generated validator.
     * @var string The error message to the generated validator.
     */
    protected $message;

    /**
     * The key-value pairs to insert in the generated validator.
     * @var array The key-value pairs to insert in the generated validator.
     */
    protected $values = array();

    /**
     * Creates a new validation value for a validation set.
     * 
     * @param string|IValidator $validator The validator to build be it a class name (fully qualified)
     *                                     or a dummy validator object.
     * @param mixed ...$params The parameters to the validator. To use a field from the validated
     *                         object, set these as ValidationKey objects.
     */
    public function __construct($validator)
    {
        if (is_object($validator))
        {
            if (!($validator instanceof IValidator))
            {
                throw new \InvalidArgumentException(Intl\GetText::_d('Flikore.Validator', 'The validator object must be a implementation of IValidator'));
            }
            else
            {
                $this->validator = get_class($validator);
            }
        }
        elseif (is_string($validator))
        {
            if (!is_subclass_of($validator, 'Flikore\Validator\Interfaces\IValidator'))
            {
                throw new \InvalidArgumentException(Intl\GetText::_d('Flikore.Validator', 'The validator object must be a implementation of IValidator'));
            }
            else
            {
                $this->validator = $validator;
            }
        }
        else
        {
            throw new \InvalidArgumentException(Intl\GetText::_d('Flikore.Validator', 'The validator object must be a implementation of IValidator'));
        }

        $params = func_get_args();
        array_shift($params);

        foreach ($params as $arg)
        {
            if ($arg instanceof ValidationKey)
            {
                $this->fields[] = $arg->getKey();
            }
        }

        $this->args = $params;
    }

    /**
     * Adds a new key-value pair to be replaced by the templating engine of 
     * the generated validator. This does not check if it's replacing a 
     * specific validator value.
     * 
     * @param string $key The key to replace (in the template as "%key%")
     * @param mixed $value The value to be inserted instead of the key.
     */
    public function addKeyValue($key, $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * Sets the error message for the generated validator.
     * @param string $message The message.
     */
    public function setErrorMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Creates a new concrete validator rule based on the given array.
     * Such array is created automatically by ValidationSet.
     * 
     * @param array $fields The key-value fileds
     * @return Validator The built validator.
     */
    public function createRule($fields)
    {
        $params = $this->args;

        foreach ($params as $i => $arg)
        {
            if ($arg instanceof ValidationKey)
            {
                $key = $arg->getKey();
                if (!isset($fields[$key]))
                {
                    throw new \OutOfBoundsException(sprintf(Intl\GetText::_d('Flikore.Validator', 'The "%s" key is missing in the input'), $key));
                }
                $params[$i] = $fields[$key];
            }
        }

        $ref = new \ReflectionClass($this->validator);
        $rule = $ref->newInstanceArgs($params);
        if ($this->message)
        {
            $rule->setErrorMessage($this->message);
        }
        foreach ($this->values as $key => $value)
        {
            $rule->addKeyValue($key, $value);
        }
        return $rule;
    }

    /**
     * Gets the fields needed to construct the delegated validator.
     * 
     * @return array The list of fields.
     */
    public function getFields()
    {
        return $this->fields;
    }

}
