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
 * Validates that the given date is at least a certain number of years ago.
 * 
 * @customKey <i>%minAge%</i> The minimum valid age.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class MinAgeValidator extends \Flikore\Validator\Validator
{

    /**
     * The minimum valid age.
     * @var int The minimum valid age.
     */
    protected $minAge;

    /**
     * The error message for this validator.
     * @var string The error message for this validator.
     */
    protected $message = 'The %key% must be older than %minAge% years.';

    /**
     * Creates a new Date Validator.
     * @param int $minAge The minimum valid age.
     */
    public function __construct($minAge)
    {
        if(!is_numeric($minAge))
        {
            throw new \InvalidArgumentException('The minimum age must be a number.');
        }
        
        $this->minAge = (int) $minAge;
        $this->addKeyValue('minAge', $this->minAge);
    }

    /**
     * Executes the real validation so it can be reused.
     * @param mixed $value The value to validate.
     * @return boolean Whether the value pass the validation.
     */
    protected function doValidate($value)
    {
        //ignore empty values
        if ($this->isEmpty($value))
        {
            return true;
        }
        
        // Validate the given value as a valid date.
        $v = new DateValidator();
        if(!$v->validate($value))
        {
            return false;
        }
        
        $givenDate = $value;
        if(!($givenDate instanceof \DateTime))
        {
            $givenDate = new \DateTime($value);
        }
        
        $ageDate = new \DateTime(date(DATE_ISO8601, strtotime('-' . $this->minAge . ' years')));
        
        return $givenDate <= $ageDate;
    }

}
