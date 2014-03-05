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
 * This class can be used as a validation rule in a set to use the fields from the object
 * being validate as an input to the constructor of a validator. This delegates the proper
 * construction of the validation until there are an object to validate.
 *
 * @author George Marques <george at georgemarques.com.br>
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
     * Creates a new validation value for a validation set.
     * 
     * @param string|Validator $validator The validator to build be it a class name (fully qualified)
     *                                    or a dummy validator object.
     * @param mixed ...$params The parameters to the validator. To use a field from the validated
     *                         object, set these as ValidationKey objects.
     */
    public function __construct($validator)
    {
        if (is_object($validator))
        {
            if (!($validator instanceof Validator))
            {
                throw new \InvalidArgumentException(dgettext('Flikore.Validator', 'The validator object must be a subclass of Validator'));
            }
            else
            {
                $this->validator = get_class($validator);
            }
        }
        elseif (is_string($validator))
        {
            if (!is_subclass_of($validator, 'Flikore\Validator\Validator'))
            {
                throw new \InvalidArgumentException(dgettext('Flikore.Validator', 'The validator object must be a subclass of Validator'));
            }
            else
            {
                $this->validator = $validator;
            }
        }
        else
        {
            throw new \InvalidArgumentException(dgettext('Flikore.Validator', 'The validator object must be a subclass of Validator'));
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
                    throw new \OutOfBoundsException(dgettext('Flikore.Validator', sprintf('The "%s" key is missing in the input', $key)));
                }
                $params[$i] = $fields[$key];
            }
        }
        
        $ref = new \ReflectionClass($this->validator);
        return $ref->newInstanceArgs($params);
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
