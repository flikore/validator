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
 * Tests for AfterDateTimeValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.2
 * @since 0.4.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class AfterDateTimeValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidatePass()
    {
        $v1 = new AfterDateTimeValidator(new \DateTime);
        
        $this->assertTrue($v1->validate(new \DateTime('+1 second')));
        $this->assertTrue($v1->validate(new \DateTime('+1 day')));
        
        $v2 = new AfterDateTimeValidator(new \DateTime('2014-03-05'));
        $this->assertTrue($v2->validate(new \DateTime('2014-03-06')));
        $this->assertTrue($v2->validate('2014-03-06'));
    }
    
    public function testValidateFail()
    {
        $v1 = new AfterDateTimeValidator(new \DateTime);
        
        $this->assertFalse($v1->validate(new \DateTime));
        $this->assertFalse($v1->validate(new \DateTime('-1 second')));
        $this->assertFalse($v1->validate(new \DateTime('-1 day')));
        
        $v2 = new AfterDateTimeValidator(new \DateTime('2014-03-05'));
        
        $this->assertFalse($v2->validate('2014-03-04'));
        $this->assertFalse($v2->validate('2014-02-20'));
        $this->assertFalse($v2->validate(new \DateTime('2014-03-05')));
        $this->assertFalse($v2->validate('2014-03-05'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongFormatArgument()
    {
        new AfterDateTimeValidator(new \DateTime, 234);
    }

    public function testValidateEmptyValue()
    {
        $v = new AfterDateTimeValidator(new \DateTime);
        
        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }
    
    public function testValidateFailNotADate()
    {
        $v = new AfterDateTimeValidator(new \DateTime);
        
        $this->assertFalse($v->validate('aaa'));
        $this->assertFalse($v->validate(25));
        $this->assertFalse($v->validate(0));
        $this->assertFalse($v->validate(new \stdClass));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNullFormatArgument()
    {
        new AfterDateTimeValidator(new \DateTime(), null);
    }

}
