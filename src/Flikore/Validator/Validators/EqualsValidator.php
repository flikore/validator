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
 * Validates if a value is equal to another.
 * 
 * @customKey <i>%compare%</i> The value to be compared to.
 * @customKey <i>%strict%</i> Whether the comparison is done in strict form.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @since 0.3
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class EqualsValidator extends \Flikore\Validator\Validator
{

    /**
     * The error message for this validator.
     * @var string The error message for this validator.
     */
    protected $message = 'The %key% must be equal to "%compare%".';

    /**
     * The value to be compared to.
     * @var mixed The value to be compared to.
     */
    protected $compare;

    /**
     * Whether the comparison should be done in strict form.
     * @var boolean Whether the comparison should be done in strict form.
     */
    protected $strict;

    /**
     * Creates a new Equals Validator.
     * @param mixed $compare The value to compare to.
     * @param boolean $strict Whether the comparison should be strict.
     */
    public function __construct($compare, $strict = false)
    {
        $this->compare = $compare;
        $this->strict = (bool) $strict;

        $this->addKeyValue('compare', $compare);
        $this->addKeyValue('strict', $strict ? 'true' : 'false');
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
        return $this->strict ? ($value === $this->compare) : ($value == $this->compare);
    }

}
