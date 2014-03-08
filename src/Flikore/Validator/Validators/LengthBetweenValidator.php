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
 * Validates that the number of characters of the value is between a certain range.
 * 
 * @customKey <i>%min%</i> The minimum valid length.
 * @customKey <i>%max%</i> The maximum valid length.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @since 0.2
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class LengthBetweenValidator extends \Flikore\Validator\Validator
{

    /**
     * The minimum valid length.
     * @var int The minimum valid length.
     */
    protected $min;

    /**
     * The maximum valid length.
     * @var int The maximum valid length.
     */
    protected $max;

    /**
     * The error message for this validator.
     * @var string The error message for this validator.
     */
    protected $message = 'The %key% must have between %min% and %max% characters.';

    /**
     * Creates a new Length Between Validator.
     * @param int $min The minimum valid length.
     * @param int $max The maximum valid length.
     */
    public function __construct($min, $max)
    {
        if (!is_int($min))
        {
            throw new \InvalidArgumentException('The minimum must be a valid integer');
        }
        if (!is_int($max))
        {
            throw new \InvalidArgumentException('The maximum must be a valid integer');
        }

        $this->min = $min;
        $this->max = $max;

        $this->addKeyValue('min', $min);
        $this->addKeyValue('max', $max);
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
        return (strlen($value) >= $this->min and strlen($value) <= $this->max);
    }

}
