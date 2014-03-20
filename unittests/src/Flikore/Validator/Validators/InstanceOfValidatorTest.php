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
 * Tests for InstanceOfValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.1
 * @since 0.2
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class InstanceOfValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidIntegerArgument()
    {
        $v = new InstanceOfValidator(123);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidNullArgument()
    {
        $v = new InstanceOfValidator(null);
    }
    
    public function testSuccessClassName()
    {
        $a = new \BadFunctionCallException();

        $v = new InstanceOfValidator('BadFunctionCallException');

        $this->assertTrue($v->validate($a));
    }

    public function testSuccessObject()
    {
        $a = new \BadFunctionCallException();

        $v = new InstanceOfValidator($a);

        $this->assertTrue($v->validate($a));
    }

    public function testFailClassName()
    {
        $a = new \BadFunctionCallException();

        $v = new InstanceOfValidator('InvalidArgumentException');

        $this->assertFalse($v->validate($a));
    }

    public function testFailObject()
    {
        $a = new \BadFunctionCallException();
        $b = new \InvalidArgumentException();

        $v = new InstanceOfValidator($b);

        $this->assertFalse($v->validate($a));
    }

    public function testSuccessEmpty()
    {
        $a = new \BadFunctionCallException();

        $v = new InstanceOfValidator($a);

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

}
