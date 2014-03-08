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

namespace Flikore\Validator\Validators;

/**
 * Validates that a value is not equal to another.
 * 
 * @customKey <i>%compare%</i> The value to be compared to.
 * @customKey <i>%strict%</i> Whether the comparison is done in strict form.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class NotEqualsValidator extends \Flikore\Validator\Validators\EqualsValidator
{

    /**
     * The error message for this validator.
     * @var string The error message for this validator.
     */
    protected $message = 'The %key% must not be equal to "%compare%".';

    /**
     * Creates a new Not Equals Validator.
     * @param mixed $compare The value to compare to.
     * @param boolean $strict Whether the comparison should be strict.
     */
    public function __construct($compare, $strict = false)
    {
        parent::__construct($compare, $strict);
    }

    /**
     * Executes the real validation so it can be reused.
     * @param mixed $value The value to validate.
     * @return boolean Whether the value pass the validation.
     */
    protected function doValidate($value)
    {
        // ignore empty values
        if ($this->isEmpty($value))
        {
            return true;
        }
        return !parent::doValidate($value);
    }

}
