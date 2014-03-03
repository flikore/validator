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
 * Validates that the value is a valid date.
 * 
 * @customKey <i>%format%</i> The format specified to check the valid date.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class DateValidator extends \Flikore\Validator\Validator
{

    /**
     * The format of the date.
     * @var string The format of the date.
     */
    protected $format;

    /**
     * The error message for this validator.
     * @var string The error message for this validator.
     */
    protected $message = 'The %key% must be a valid date.';

    /**
     * The alternative message used if there is a specified format.
     * @var string The alternative message used if there is a specified format.
     */
    protected $alt_message = 'The %key% must be a date in the format "%format%".';

    /**
     * Creates a new Date Validator.
     * @param s $format The format of the date (if any).
     */
    public function __construct($format = null)
    {
        if (!is_null($format) && !is_string($format))
        {
            throw new \InvalidArgumentException('The format must be a string if not null.');
        }

        $this->format = $format;

        if ($format !== null)
        {
            $this->addKeyValue('format', $format);
            $this->setErrorMessage($this->alt_message);
        }
    }

    /**
     * Executes the real validation so it can be reused.
     * @param mixed $value The value to validate.
     * @return boolean Whether the value pass the validation.
     */
    protected function doValidate($value)
    {
        // ignore empty values
        if (is_null($value) || $value === '')
        {
            return true;
        }
        if ($value instanceof \DateTime)
        {
            return true;
        }
        if (!is_string($value))
        {
            return false;
        }
        if (is_null($this->format))
        {
            return (strtotime($value) !== false);
        }
        $date = \DateTime::createFromFormat($this->format, $value);
        return $date && $value === date($this->format, $date->getTimestamp());
    }

}
