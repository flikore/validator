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
 * Tests for ValueBetweenValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.2
 * @since 0.3
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class ValueBetweenValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $val = new ValueBetweenValidator(2, 4);
        
        $this->assertTrue($val->validate(2));
        $this->assertTrue($val->validate(3));
        $this->assertTrue($val->validate(4));
    }

    public function testValidateFail()
    {
        $val = new ValueBetweenValidator(2, 4);
        
        $this->assertFalse($val->validate(-2));
        $this->assertFalse($val->validate(0));
        $this->assertFalse($val->validate(1));
        $this->assertFalse($val->validate(5));
        $this->assertFalse($val->validate(PHP_INT_MAX));
    }
    
    public function testValidateNotIntegerSuccess()
    {
        $val = new ValueBetweenValidator(2, 4);
        
        $this->assertTrue($val->validate('2'));
        $this->assertTrue($val->validate('3'));
        $this->assertTrue($val->validate('4'));
    }
    
    public function testValidateNotIntegerFail()
    {
        $val = new ValueBetweenValidator(2, 4);
        
        $this->assertFalse($val->validate('not a number'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongMinValueArgument()
    {
        new ValueBetweenValidator('aa', 4);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongMaxValueArgument()
    {
        new ValueBetweenValidator(4, 'a');
    }

    public function testValidateEmptyValue()
    {
        $val = new ValueBetweenValidator(2, 4);
        $this->assertTrue($val->validate(''));
        $this->assertTrue($val->validate(null));
    }

    public function testMinValueMessage()
    {
        $val = new ValueBetweenValidator(0, 3);
        $val->setErrorMessage('%min%');
        
        $this->assertEquals('0', $val->getErrorMessage());
    }
    
    public function testMaxValueMessage()
    {
        $val = new ValueBetweenValidator(0, 3);
        $val->setErrorMessage('%max%');
        
        $this->assertEquals('3', $val->getErrorMessage());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNullMinValueArgument()
    {
        new ValueBetweenValidator(null, 3);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNullMaxValueArgument()
    {
        new ValueBetweenValidator(0, null);
    }
}
