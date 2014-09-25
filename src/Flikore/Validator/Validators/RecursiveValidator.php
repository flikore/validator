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

use Flikore\Validator\Interfaces\IValidator;

/**
 * Validates that each of the elements of an array pass a validator.
 * 
 * @customKey <i>%arrKey%</i> The array key that failed the validation (only after validating).
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.2
 * @since 0.4.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class RecursiveValidator extends \Flikore\Validator\Validator
{
    /**
     * Stores the validator used to check the values.
     * @var IValidator Stores the validator used to check the values.
     */
    protected $validator;

    /**
     * The error message for this validator.
     * @var string The error message for this validator.
     */
    protected $message = 'The %key% failed to validate on key %arrKey%.';
    
    /**
     * Creates a new Recursive Validator.
     * 
     * @param IValidator $validator The validator to use when checking.
     */
    public function __construct(IValidator $validator)
    {
        $this->validator = $validator;
        $this->addKeyValue('arrKey', null);
    }

    /**
     * Executes the real validation so it can be reused.
     * @param mixed $value The value to validate.
     * @return boolean Whether the value pass the validation.
     */
    protected function doValidate($value)
    {
        if($this->isEmpty($value) || (is_array($value) && empty($value)))
        {
            return true;
        }
        foreach ($value as $key => $check)
        {
            if(!$this->validator->validate($check))
            {
                $this->addKeyValue('arrKey', $key);
                return false;
            }
        }
        return true;
    }

}
