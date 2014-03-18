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

/**
 * Combines two or more validator objects into one. This validates with all
 * the inserted validators and stops at the first error, return the message
 * of the validator that went wrong.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.0
 * @since 0.2
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
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
    protected $validators = array();

    /**
     * Adds a new validator to the combo.
     * @param Validator $validator The validator to add.
     */
    public function addValidator(Validator $validator)
    {
        $validator->addKeyValue('key', $this->values['key']);
        array_push($this->validators, $validator);
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
            if (!$rule->validate($value))
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
