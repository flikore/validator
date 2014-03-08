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

namespace Flikore\Validator;

/**
 * Represents a specific field in a set. To be used inside a ValidatorValue, representing
 * a property in the object being validated instead of raw immediate value.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @since 0.4.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class ValidationKey
{
    /**
     * The name of the key to pull from the validated object.
     * @var string The name of the key to pull from the validated object.
     */
    protected $key;
    
    /**
     * Creates a new ValidationValue object.
     * @param string $key The name of the key to pull from the validated object.
     */
    public function __construct($key)
    {
        if(is_null($key))
        {
            throw new \InvalidArgumentException('The key name must not be null');
        }
        if(!is_string($key))
        {
            if(is_array($key) || (is_object($key) && !method_exists($key, '__toString')))
            {
                throw new \InvalidArgumentException('The key name must be convertible to string');
            }
            $key = (string) $key;
        }
        
        $this->key = $key;
    }
    
    /**
     * Gets the name of the key to pull from the validated object.
     * @return string The key.
     */
    public function getKey()
    {
        return $this->key;
    }
}
