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
 * Tests for ValidationValue class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class ValidationValueTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFieldsObject()
    {
        $v = new ValidationValue(new Validators\EqualsValidator('dummy'), new ValidationKey('name'));
        
        $this->assertContains('name', $v->getFields());
    }
    
    public function testGetFieldsClassName()
    {
        $v = new ValidationValue('Flikore\Validator\Validators\EqualsValidator', new ValidationKey('name'));
        
        $this->assertContains('name', $v->getFields());
    }
    
    public function testCreateRule()
    {
        $v = new ValidationValue('Flikore\Validator\Validators\EqualsValidator', new ValidationKey('name'));
        
        $rule = $v->createRule(array('name' => 'same thing'));
        
        $this->assertInstanceOf('Flikore\Validator\Validators\EqualsValidator', $rule);
        $this->assertTrue($rule->validate('same thing'));
        $this->assertFalse($rule->validate('other thing'));
    }
    
    public function testCreateRuleWithAddKey()
    {
        $v = new ValidationValue(new Validators\EqualsValidator('dummy'), new ValidationKey('name'));
        
        $v->addKeyValue('test', 'this is value');
        
        $rule = $v->createRule(array('name' => 'same thing'));
        $rule->setErrorMessage('%test%');
        
        $this->assertEquals('this is value', $rule->getErrorMessage());
    }
    
    public function testCreateRuleWithSetMessage()
    {
        $v = new ValidationValue(new Validators\EqualsValidator('dummy'), new ValidationKey('name'));
        $v->setErrorMessage('this is message');
        
        $rule = $v->createRule(array('name' => 'same thing'));
        
        $this->assertEquals('this is message', $rule->getErrorMessage());
    }
    
    /**
     * @expectedException \OutOfBoundsException
     */
    public function testCreateRuleErrorMissingKey()
    {
        $v = new ValidationValue('Flikore\Validator\Validators\EqualsValidator', new ValidationKey('name'));
        
        $v->createRule(array('missingNameKey' => 'same thing'));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructWrongTypeObject()
    {
        new ValidationValue(new \stdClass(), new ValidationKey('name'));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructWrongTypeString()
    {
        new ValidationValue('stdClass', new ValidationKey('name'));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructWrongTypeNumber()
    {
        new ValidationValue(0, new ValidationKey('name'));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructWrongTypeNull()
    {
        new ValidationValue(null, new ValidationKey('name'));
    }

}
