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
 * Validates if a string is a valid URI.
 * 
 * @customKey <i>%protocol%</i> The valid(s) protocol(s) set in the constructor.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 */
class UriValidator extends \Flikore\Validator\Validator
{

    /**
     * The error message for this validator.
     * @var string The error message for this validator.
     */
    protected $message = 'The %key% must be a valid URI.';

    /**
     * An alternative error message for this validator for when the protocol is set.
     * @var string An alternative error message for this validator for when the protocol is set.
     */
    protected $message_protocol = 'The %key% must be a valid URI and use the %protocol% protocol.';

    /**
     * The valid(s) protocol(s).
     * @var mixed The valid(s) protocol(s).
     */
    protected $protocol;

    /**
     * Creates a new Uri Validator.
     * @param mixed $protocol The valid(s) protocol(s) (string or array).
     */
    public function __construct($protocol = null)
    {
        if (is_array($protocol) && empty($protocol))
        {
            throw new \InvalidArgumentException('The valid procotol list cannot be empty');
        }
        elseif (is_object($protocol) && (!($protocol instanceof \Traversable)))
        {
            throw new \InvalidArgumentException('The protocol argument cannot be a noniterable object');
        }
        elseif ($protocol !== null)
        {
            $this->setErrorMessage($this->message_protocol);
        }
        $this->protocol = $protocol;
        $this->addKeyValue('protocol', $protocol);
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
        $uri_valid = $value === filter_var($value, FILTER_VALIDATE_URL);
        if (!$this->protocol)
        {
            return $uri_valid;
        }
        else
        {
            if (is_array($this->protocol) || $this->protocol instanceof \Traversable)
            {
                $protocol_valid = false;
                foreach ($this->protocol as $pt)
                {
                    if (strpos($value, $pt . '://') === 0)
                    {
                        $protocol_valid = true;
                    }
                }
                return $uri_valid && $protocol_valid;
            }
            else
            {
                if (strpos($value, $this->protocol . '://') !== 0)
                {
                    return false;
                }
                else
                {
                    return $uri_valid;
                }
            }
        }
    }

}
