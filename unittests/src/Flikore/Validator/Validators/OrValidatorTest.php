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
 * Tests for OrValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.4.0
 * @since 0.4.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class OrValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $v = new OrValidator(
                new NumericValidator(), new AlphaValidator()
        );

        $this->assertTrue($v->validate('654')); // numeric, ok
        $this->assertTrue($v->validate(654)); // numeric, ok
        $this->assertTrue($v->validate('sda')); // alpha, ok
    }

    public function testValidateFail()
    {
        $v = new OrValidator(
                new NumericValidator(), new AlphaValidator()
        );

        $this->assertFalse($v->validate(new \stdClass())); // object, not ok
        $this->assertFalse($v->validate('2014-12-12')); // not aplha nor numeric, not ok
    }
    
    public function testMessages()
    {
        $v1 = new NumericValidator();
        $v1->setErrorMessage('numeric');
        
        $v2 = new AlphaValidator();
        $v2->setErrorMessage('alpha');
        
        $v = new OrValidator(
                $v1, $v2
        );

        $v->setErrorMessage('%v1%');
        $this->assertEquals($v1->getErrorMessage(), $v->getErrorMessage());
        
        $v->setErrorMessage('%v2%');
        $this->assertEquals($v2->getErrorMessage(), $v->getErrorMessage());
    }
    
    public function testSetInternalMessages()
    {
        $v1 = new NumericValidator();
        $v1->setErrorMessage('%custom%');
        
        $v2 = new AlphaValidator();
        $v2->setErrorMessage('%custom%');
        
        $v = new OrValidator(
                $v1, $v2
        );
        
        $v->addKeyValue('custom', 'this is test');

        $v->setErrorMessage('%v1%');
        $this->assertEquals('this is test', $v->getErrorMessage());
        
        $v->setErrorMessage('%v2%');
        $this->assertEquals('this is test', $v->getErrorMessage());
    }

    public function testValidateFailEmptyValidators()
    {
        $v = new OrValidator(
                new NotEmptyValidator(), new NotEmptyValidator()
        );

        $this->assertFalse($v->validate(''));
        $this->assertFalse($v->validate(null));
    }

    public function testValidateEmpty()
    {
        $v = new OrValidator(
                new NumericValidator(), new AlphaValidator()
        );

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNotValidatorThirdParam()
    {
        new OrValidator(new NotEmptyValidator(), new AlphaValidator(), new \stdClass());
    }
}
