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

namespace Flikore\Validator\Validators;

use Flikore\Validator\Intl;

/**
 * Validates that a date/time is before a given reference.
 * 
 * @customKey <i>%date%</i> The reference date/time.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.2
 * @since 0.4.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class BeforeDateTimeValidator extends \Flikore\Validator\Validator
{

    /**
     * The reference date/time.
     * @var \DateTime The reference date/time.
     */
    protected $date;

    /**
     * The error message for this validator.
     * @var string The error message for this validator.
     */
    protected $message = 'The %key% must be before than %date%.';

    /**
     * Creates a new Before Date Validator.
     * 
     * @param \DateTime $date The reference date/time.
     * @param string $format The format of the date to show in the error message.
     */
    public function __construct(\DateTime $date, $format = DATE_RFC3339)
    {
        if(!is_string($format))
        {
            throw new \InvalidArgumentException(Intl\GetText::_d('Flikore.Validator', 'The format argument must be a string.'));
        }
        
        $this->date = $date;

        $this->addKeyValue('date', $date->format($format));
    }

    /**
     * Executes the real validation so it can be reused.
     * 
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
        $isDate = new DateTimeValidator();
        if(!$isDate->validate($value))
        {
            return false;
        }
        if(is_string($value))        
        {
            $value = new \DateTime($value);
        }
        
        return $value < $this->date;
    }

}
