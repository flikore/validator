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
 * Tests for DateTimeValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.1
 * @since 0.4.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class DateTimeValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $date = '12-12-1988';
        $v = new DateTimeValidator();
        $this->assertTrue($v->validate($date));
    }

    public function testValidatePassWithFormat()
    {
        $date1 = '31-03-2013';
        $date2 = '28-02-2013';
        $v = new DateTimeValidator('d-m-Y');
        $this->assertTrue($v->validate($date1));
        $this->assertTrue($v->validate($date2));
    }

    public function testValidatePassWithObject()
    {
        $date = new \DateTime();
        $v = new DateTimeValidator();
        $this->assertTrue($v->validate($date));
    }

    public function testValidateFail()
    {
        $v = new DateTimeValidator();
        $this->assertFalse($v->validate('aaa'));
        $this->assertFalse($v->validate(25));
        $this->assertFalse($v->validate(0));
        $this->assertFalse($v->validate(new \stdClass));
    }

    public function testValidateFailWithFormat()
    {
        $date1 = '31-3-2013';
        $date2 = '28-2-2013';
        $v = new DateTimeValidator('d-m-Y');
        $this->assertFalse($v->validate($date1));
        $this->assertFalse($v->validate($date2));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongFormatArgument()
    {
        new DateTimeValidator(323);
    }

    public function testValidateEmptyValue()
    {
        $v = new DateTimeValidator();
        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

}
