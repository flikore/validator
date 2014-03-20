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
 * Tests for EqualsValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.1
 * @since 0.3
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class EqualsValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $v = new EqualsValidator('aa');
        $this->assertTrue($v->validate('aa'));
        $this->assertTrue($v->validate(0));
        
        $v = new EqualsValidator(0);
        $this->assertTrue($v->validate(0));
        $this->assertTrue($v->validate('0'));
        $this->assertTrue($v->validate('a'));
        
        $v = new EqualsValidator(new \stdClass());
        $this->assertTrue($v->validate(new \stdClass()));
    }

    public function testValidateFail()
    {
        $v = new EqualsValidator('aa');
        $this->assertFalse($v->validate('aaa'));
        
        $v = new EqualsValidator(0);
        $this->assertFalse($v->validate(1));
        $this->assertFalse($v->validate('1'));
        
        $v = new EqualsValidator(new \stdClass());
        $this->assertFalse($v->validate(new \ArrayIterator()));
    }
    
    public function testValidateStrictPass()
    {
        $v = new EqualsValidator('aa', true);
        $this->assertTrue($v->validate('aa'));
        
        $v = new EqualsValidator(0, true);
        $this->assertTrue($v->validate(0));
        
        $obj = new \stdClass();
        $v = new EqualsValidator($obj, true);
        $this->assertTrue($v->validate($obj));
    }

    public function testValidateStrictFail()
    {
        $v = new EqualsValidator('aa', true);
        $this->assertFalse($v->validate('aaa'));
        
        $v = new EqualsValidator(0, true);
        $this->assertFalse($v->validate(1));
        $this->assertFalse($v->validate('0'));
        
        $v = new EqualsValidator(new \stdClass(), true);
        $this->assertFalse($v->validate(new \stdClass()));
    }

    public function testValidateEmptyValue()
    {
        $v = new EqualsValidator('any');

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }
    
    public function testMessageKeys()
    {
        $v = new EqualsValidator('any', true);
        
        $v->setErrorMessage('%compare%');
        $this->assertEquals('any', $v->getErrorMessage());
        
        $v->setErrorMessage('%strict%');
        $this->assertEquals('true', $v->getErrorMessage());
        
        $v = new EqualsValidator('any', false);
                
        $v->setErrorMessage('%strict%');
        $this->assertEquals('false', $v->getErrorMessage());
        
    }

}
