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

namespace Flikore\Validator;

use Flikore\Validator\Validators\ExactValueValidator;
use Flikore\Validator\Validators\MaxValueValidator;
use Flikore\Validator\Validators\MinValueValidator;

/**
 * Tests for ValidationCombo class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class ValidationComboTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ValidationCombo
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ValidationCombo;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testComboValidationSuccess()
    {
        $v = $this->object;
        $v->addValidator(new MinValueValidator(5));
        $v->addValidator(new MaxValueValidator(9));

        $this->assertTrue($v->validate(5));
        $this->assertTrue($v->validate(6));
        $this->assertTrue($v->validate(7));
        $this->assertTrue($v->validate(8));
        $this->assertTrue($v->validate(9));
    }

    /**
     * @expectedException Flikore\Validator\Exception\ValidatorException
     */
    public function testComboValidationFailure()
    {
        $v = $this->object;
        $v->addValidator(new MinValueValidator(9));
        $v->addValidator(new MaxValueValidator(5));

        ($v->assert(5));
        ($v->assert(6));
        ($v->assert(7));
        ($v->assert(8));
        ($v->assert(9));
    }

    public function testAddKeyValue()
    {
        $v = $this->object;
        $a = new ExactValueValidator(5);

        $msgA = 'msgA';

        $v->addValidator($a);
        $v->addKeyValue('key', $msgA);

        $this->setExpectedException('Flikore\Validator\Exception\ValidatorException', $a->getErrorMessage());

        $v->assert(0);
    }

    public function testCustomMessage()
    {
        $v = $this->object;
        $a = new ExactValueValidator(5);

        $msg = 'This is the test message';

        $v->setErrorMessage($msg);
        $v->addValidator($a);

        $this->setExpectedException('Flikore\Validator\Exception\ValidatorException', $msg);

        $v->assert(0);
    }

}
