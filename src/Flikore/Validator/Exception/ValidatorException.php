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

namespace Flikore\Validator\Exception;

/**
 * An exception thrown if there are any validation error.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.1
 * @since 0.1
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Exceptions
 */
class ValidatorException extends \Exception
{

    /**
     * The inner exceptions.
     * @var ValidatorException[] The inner exceptions.
     */
    protected $errors = array();

    /**
     * Gets the inner exceptions from a set of validators.
     * @return ValidatorException[] The set of exceptions.
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Gets the inner exception for a specific key.
     * @param string $key The key to get.
     * @return ValidatorException The exception of that key or null if there's none.
     */
    public function getError($key)
    {
        return isset($this->errors[$key]) ? $this->errors[$key] : null;
    }

    /**
     * Sets the inner exceptions for this exception.
     * @param array $errors The set of exceptions.
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Sets the inner exceptions for a specific key.
     * @param ValidatorException $error The exception.
     * @param string $key The key name.
     */
    public function setError($error, $key)
    {
        $this->errors[$key] = $error;
    }
    
    /**
     * Gets all the messages as an array. If there's no inner exceptions (i.e. this is not a set error), then
     * an array will be returned with the message being in the key 0. If the inner exceptions are also from a
     * set, then there'll be an array of messages set to that key (i.e. this will be a nested array of messages).
     * 
     * @return array The collection of messages.
     */
    public function getMessages()
    {
        $errors = $this->getErrors();
        
        if(empty($errors))
        {
            return array(0 => $this->getMessage());
        }
        
        $result = array();
        
        foreach ($errors as $key => $err)
        {
            $innerErrors = $err->getErrors();
            if(empty($innerErrors))
            {
                $result[$key] = $err->getMessage();
            }
            else
            {
                $result[$key] = $err->getMessages();
            }
        }
        return $result;
    }
}
