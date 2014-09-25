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
 * Tests for LengthBetweenValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.1
 * @since 0.2
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class LengthBetweenValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $v = new LengthBetweenValidator(2, 4);
        $this->assertTrue($v->validate('aa'));
        $this->assertTrue($v->validate('aaa'));
        $this->assertTrue($v->validate('aaaa'));
    }

    public function testValidateFail()
    {
        $v = new LengthBetweenValidator(2, 4);
        $this->assertFalse($v->validate('aaaaa'));
        $this->assertFalse($v->validate('a'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongMinLengthArgument()
    {
        new LengthBetweenValidator('aa', 4);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongMaxLengthArgument()
    {
        new LengthBetweenValidator(4, 'a');
    }

    public function testValidateEmptyValue()
    {
        $v = new LengthBetweenValidator(2, 4);
        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNullMaxValueArgument()
    {
        new LengthBetweenValidator(3, null);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNullMinValueArgument()
    {
        new LengthBetweenValidator(null, 3);
    }
}
