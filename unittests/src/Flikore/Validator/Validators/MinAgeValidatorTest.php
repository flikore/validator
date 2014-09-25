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
 * Tests for MinAgeValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.2
 * @since 0.3
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class MinAgeValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $v = new MinAgeValidator(20);
        
        $d1 = date('Y-m-d', strtotime('-20 years'));
        $d2 = date('Y-m-d', strtotime('-30 years'));
        
        $this->assertTrue($v->validate($d1));
        $this->assertTrue($v->validate($d2));
    }

    public function testValidateFail()
    {
        $v = new MinAgeValidator(20);
        
        $d1 = date('Y-m-d', strtotime('-19 years +364 days'));
        $d2 = date('Y-m-d');
        
        $this->assertFalse($v->validate($d1));
        $this->assertFalse($v->validate($d2));
    }
    
    public function testValidateNotDateFail()
    {
        $v = new MinAgeValidator(20);
        
        $d1 = 'this is not a date';
        
        $this->assertFalse($v->validate($d1));
    }
    
    public function testValidateDateTimeObjectSuccess()
    {
        $v = new MinAgeValidator(20);
        
        $d1 = new \DateTime(date(DATE_ISO8601, strtotime('-20 years')));
        $d2 = new \DateTime(date(DATE_ISO8601, strtotime('-30 years')));
        
        $this->assertTrue($v->validate($d1));
        $this->assertTrue($v->validate($d2));
    }
    
    public function testValidateDateTimeObjectFail()
    {
        $v = new MinAgeValidator(20);
        
        $d1 = new \DateTime(date(DATE_ISO8601, strtotime('-19 years +364 days')));
        $d2 = new \DateTime();
        
        $this->assertFalse($v->validate($d1));
        $this->assertFalse($v->validate($d2));
    }
    
    public function testNumericStringArgumentOk()
    {
        $v = new MinAgeValidator('20');
        
        $d1 = date('Y-m-d', strtotime('-20 years'));
        $d2 = date('Y-m-d', strtotime('-30 years'));
        
        $this->assertTrue($v->validate($d1));
        $this->assertTrue($v->validate($d2));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongMinAgeArgumentString()
    {
        new MinAgeValidator('not valid');
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongMinAgeArgumentNotGiven()
    {
        new MinAgeValidator(null);
    }

    public function testValidateEmptyValue()
    {
        $v = new MinAgeValidator(20);
        
        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

    public function testMinAgeMessage()
    {
        $min = '20';
        $v = new MinAgeValidator($min);
        $v->setErrorMessage('%minAge%');
        
        $this->assertEquals($min, $v->getErrorMessage());
                
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNullMinAgeArgument()
    {
        new MinAgeValidator(null);
    }

}
