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
 * @license http://opensource.org/licenses/MIT MIT
 * @author George Marques <george at georgemarques.com.br>
 */
class RegexValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $val = new RegexValidator('/^[a-z]+$/i');
        $this->assertTrue($val->validate('aaaa'));
        $this->assertTrue($val->validate('addjkhddk'));
        $this->assertTrue($val->validate('AasASdjkD'));
    }

    public function testValidateFail()
    {
        $val = new RegexValidator('/^[a-z]+$/i');
        $this->assertFalse($val->validate(4));
        $this->assertFalse($val->validate('asd d'));
        $this->assertFalse($val->validate('8319 da9dua98s'));
        $this->assertFalse($val->validate(' '));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidRegexArgument()
    {
        $t = new RegexValidator('aaa');
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidRegexNumberArgument()
    {
        $t = new RegexValidator(0);
    }

    public function testValidateEmptyValue()
    {
        $val = new RegexValidator('/^[a-z]+$/i');
        $this->assertTrue($val->validate(''));
        $this->assertTrue($val->validate(null));
    }

}