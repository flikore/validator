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

namespace Flikore\Validator\Exception;

/**
 * Tests for ValidationException class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.4.0
 * @since 0.1
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class ValidatorExceptionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ValidatorException
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ValidatorException;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testSetAndGetErrors()
    {
        $errs = array(
            'aa' => new ValidatorException('aa'),
            'bb' => new ValidatorException('bb'),
        );

        $this->object->setErrors($errs);

        $this->assertEquals($errs, $this->object->getErrors());
    }

    public function testSetAndGetError()
    {
        $errA = new ValidatorException('aa');
        $errB = new ValidatorException('bb');

        $this->object->setError($errA, 'aa');

        $this->assertEquals($errA, $this->object->getError('aa'));
        $this->assertNotEquals($errB, $this->object->getError('aa'));
    }

}
