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

/**
 * Tests for Validator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Validator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = $this->getMockForAbstractClass('Flikore\Validator\Validator');
    }
    
    public function testGetErrorMessage()
    {
        $msg = 'Test';
        $this->object->setErrorMessage($msg);
        $this->assertEquals($msg, $this->object->getErrorMessage());
        
    }
    
    public function testValidate()
    {
        $this->object->expects($this->any())
                ->method('doValidate')
                ->will($this->returnValue(true));
        
        $this->assertTrue($this->object->validate('anything'));
    }
    
    /**
     * @expectedException \Flikore\Validator\Exception\ValidatorException
     */
    public function testAssertFail()
    {
        $this->object->expects($this->any())
                ->method('doValidate')
                ->will($this->returnValue(false));
        
        $this->object->assert('anything');
    }
    
    public function testAssertSuccess()
    {
        $this->object->expects($this->any())
                ->method('doValidate')
                ->will($this->returnValue(true));
        
        $this->object->assert('anything');
    }
    
    public function testAddKeyValue()
    {
        $v = $this->object;
        $key = 'test key';
        $value = 'test value';
        $v->addKeyValue($key, $value);
        $v->setErrorMessage("%$key%");
        
        $this->assertEquals($value, $v->getErrorMessage());
    }
    
    public function testAddKeyValueObject()
    {
        $v = $this->object;
        $key = 'test key';
        $value = new \stdClass();
        $v->addKeyValue($key, $value);
        $v->setErrorMessage("%$key%");
        
        $this->assertEquals('stdClass', $v->getErrorMessage());
    }
}
