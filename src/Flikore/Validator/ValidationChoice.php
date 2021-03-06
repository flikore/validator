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

use Flikore\Validator\Validator;

/**
 * Validates that the value pass in at least one of the given validators.
 * 
 * @customKey <i>%vN%</i> The message of the Nth validator (1-index).
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.2
 * @since 0.5.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class ValidationChoice extends Validator
{

    /**
     * An array of validators to test.
     * @var Validator[] An array of validators to test.
     */
    protected $validators = array();

    /**
     * The error message for this validator.
     * @var string The error message for this validator.
     */
    protected $message = 'The %key% must match one of the validators.';

    /**
     * Creates a new Validation Choice. You can pass as many validators as you want.
     * 
     * @param array|Validator $... The validators to check (list as arguments or in an array).
     */
    public function __construct()
    {
        $validators = func_get_args();
        
        if(count($validators) == 1 and is_array($validators[0]))
        {
            $validators = $validators[0];
        }
        
        $i = 1;
        foreach ($validators as $arg)
        {
            if (!$arg instanceof Validator)
            {
                throw new \InvalidArgumentException(Intl\GetText::_d('Flikore.Validator', 'The arguments must be intances of validators'));
            }
            $this->validators[] = $arg;
            $this->addKeyValue('v' . $i++, $arg->getErrorMessage());
        }
    }
    
    /**
     * Adds a new validator to the combo.
     * @param Validator $validator The validator to add.
     */
    public function addValidator(Validator $validator)
    {
        foreach ($this->values as $key => $value)
        {
            if (preg_match('/^v[0-9]+$/', $key) == 0)
            {
                $validator->addKeyValue($key, $value);
            }
        }
        
        array_push($this->validators, $validator);
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
        parent::addKeyValue($key, $value);

        if (preg_match('/^v[0-9]+$/', $key) == 0)
        {
            foreach ($this->validators as $v)
            {
                $v->addKeyValue($key, $value);
            }
        }
    }

    /**
     * Applies the template message to a formed one.
     * @return string The formed message.
     */
    protected function applyTemplate()
    {
        $i = 1;
        foreach ($this->validators as $v)
        {
            $this->addKeyValue('v' . $i++, $v->getErrorMessage());
        }
        return parent::applyTemplate();
    }

    /**
     * Executes the real validation so it can be reused.
     * @param mixed $value The value to validate.
     * @return boolean Whether the value pass the validation.
     */
    protected function doValidate($value)
    {
        if(empty($this->validators))
        {
            return true;
        }
        foreach ($this->validators as $v)
        {
            if($v->validate($value))
            {
                return true;
            }
        }
        return false;
    }

}
