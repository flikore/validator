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
 * Tests for DateValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class DateValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $date = '12-12-1988';
        $val = new DateValidator();
        $this->assertTrue($val->validate($date));
    }

    public function testValidatePassWithFormat()
    {
        $date1 = '31-03-2013';
        $date2 = '28-02-2013';
        $val = new DateValidator('d-m-Y');
        $this->assertTrue($val->validate($date1));
        $this->assertTrue($val->validate($date2));
    }

    public function testValidatePassWithObject()
    {
        $date = new \DateTime();
        $val = new DateValidator();
        $this->assertTrue($val->validate($date));
    }

    public function testValidateFail()
    {
        $val = new DateValidator();
        $this->assertFalse($val->validate('aaa'));
        $this->assertFalse($val->validate(25));
        $this->assertFalse($val->validate(0));
        $this->assertFalse($val->validate(new \stdClass));
    }

    public function testValidateFailWithFormat()
    {
        $date1 = '31-3-2013';
        $date2 = '28-2-2013';
        $val = new DateValidator('d-m-Y');
        $this->assertFalse($val->validate($date1));
        $this->assertFalse($val->validate($date2));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongFormatArgument()
    {
        $t = new DateValidator(323);
    }

    public function testValidateEmptyValue()
    {
        $val = new DateValidator();
        $this->assertTrue($val->validate(''));
        $this->assertTrue($val->validate(null));
    }

}
