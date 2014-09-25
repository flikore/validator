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
 * Tests for ExactLengthValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.2
 * @since 0.2
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class ExactLengthValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $string = 'aa';
        $v = new ExactLengthValidator(2);
        $this->assertTrue($v->validate($string));
    }

    public function testValidateFail()
    {
        $v = new ExactLengthValidator(2);
        $this->assertFalse($v->validate('aaa'));
        $this->assertFalse($v->validate('a'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongLengthArgument()
    {
        new ExactLengthValidator('aa');
    }

    public function testValidateEmptyValue()
    {
        $v = new ExactLengthValidator(2);

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNullLengthArgument()
    {
        new ExactLengthValidator(null);
    }

}
