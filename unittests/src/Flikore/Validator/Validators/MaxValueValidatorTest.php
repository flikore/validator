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
 * Tests for MaxValueValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.1
 * @since 0.2
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class MaxValueValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $val = new MaxValueValidator(5);
        $this->assertTrue($val->validate(0));
        $this->assertTrue($val->validate(4));
        $this->assertTrue($val->validate(5));
    }

    public function testValidateFail()
    {
        $val = new MaxValueValidator(3);
        $this->assertFalse($val->validate(4));
        $this->assertFalse($val->validate(PHP_INT_MAX));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongValueArgument()
    {
        $t = new MaxValueValidator('aa');
    }

    public function testValidateEmptyValue()
    {
        $val = new MaxValueValidator(5);
        $this->assertTrue($val->validate(''));
        $this->assertTrue($val->validate(null));
    }

}
