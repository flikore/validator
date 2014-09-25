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
 * Tests for NoSpaceValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.2
 * @since 0.5.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class NoSpaceValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $v = new NoSpaceValidator();

        $this->assertTrue($v->validate('valid'));
        $this->assertTrue($v->validate('valid_with_underscores'));
        $this->assertTrue($v->validate('valid-with-hyphens'));
        $this->assertTrue($v->validate('UPPERcase'));
        $this->assertTrue($v->validate('number213'));
        $this->assertTrue($v->validate('strángècharactérs'));
        $this->assertTrue($v->validate('~'));
        $this->assertTrue($v->validate('%%&&'));
    }

    public function testValidateFail()
    {
        $v = new NoSpaceValidator();

        $this->assertFalse($v->validate('spaces '));
        $this->assertFalse($v->validate('tabs	'));
        $this->assertFalse($v->validate("newlines\n\n"));
    }

    public function testValidateEmptyValue()
    {
        $v = new NoSpaceValidator();

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

}
