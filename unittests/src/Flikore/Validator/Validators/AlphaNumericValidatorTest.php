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
 * Tests for AlphaNumericValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class AlphaNumericValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $v = new AlphaNumericValidator();

        $this->assertTrue($v->validate('valid'));
        $this->assertTrue($v->validate('valid with spaces'));
        $this->assertTrue($v->validate('UPPERcase'));
        $this->assertTrue($v->validate('   '));
        $this->assertTrue($v->validate('numbers12312'));
        $this->assertTrue($v->validate('12312'));
    }

    public function testValidateFail()
    {
        $v = new AlphaNumericValidator();

        $this->assertFalse($v->validate('strángè charactérs'));
        $this->assertFalse($v->validate('~'));
        $this->assertFalse($v->validate('%%&&'));
    }

    public function testValidateEmptyValue()
    {
        $v = new AlphaNumericValidator();

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

}
