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

use Flikore\Validator\Validators as v;

/**
 * Tests for ValidationCombo class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.1
 * @since 0.2
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

    public function testComboValidationSuccess()
    {
        $v = $this->object;
        $v->addValidator(new v\MinValueValidator(5));
        $v->addValidator(new v\MaxValueValidator(9));

        $this->assertTrue($v->validate(5));
        $this->assertTrue($v->validate(6));
        $this->assertTrue($v->validate(7));
        $this->assertTrue($v->validate(8));
        $this->assertTrue($v->validate(9));
    }
    
    public function testComboValidationConstruct()
    {
        $v = new ValidationCombo(
            new v\MinValueValidator(5),
            new v\MaxValueValidator(9)
        );

        $this->assertTrue($v->validate(6));
        $this->assertTrue($v->validate(9));
        $this->assertFalse($v->validate(0));
        $this->assertFalse($v->validate(10));
    }
    
    public function testComboValidationConstructArray()
    {
        $v = new ValidationCombo(array(
            new v\MinValueValidator(5),
            new v\MaxValueValidator(9)
        ));

        $this->assertTrue($v->validate(6));
        $this->assertTrue($v->validate(9));
        $this->assertFalse($v->validate(0));
        $this->assertFalse($v->validate(10));
    }

    /**
     * @expectedException Flikore\Validator\Exception\ValidatorException
     */
    public function testComboValidationFailure()
    {
        $v = $this->object;
        $v->addValidator(new v\MinValueValidator(9));
        $v->addValidator(new v\MaxValueValidator(5));

        ($v->assert(5));
    }

    public function testAddKeyValue()
    {
        $v = $this->object;
        $a = new v\ExactValueValidator(5);

        $msgA = 'msgA';

        $v->addValidator($a);
        $v->addKeyValue('key', $msgA);

        $this->setExpectedException('Flikore\Validator\Exception\ValidatorException', $a->getErrorMessage());

        $v->assert(0);
    }

    public function testCustomMessage()
    {
        $v = $this->object;
        $a = new v\ExactValueValidator(5);

        $msg = 'This is the test message';

        $v->setErrorMessage($msg);
        $v->addValidator($a);

        $this->setExpectedException('Flikore\Validator\Exception\ValidatorException', $msg);

        $v->assert(0);
    }
    
    public function testZeroValidator()
    {
        $v = new ValidationCombo(); // no validator, anything is ok

        $this->assertTrue($v->validate('654'));
        $this->assertTrue($v->validate(654));
        $this->assertTrue($v->validate('sda'));
        $this->assertTrue($v->validate('sda123'));
        $this->assertTrue($v->validate(array(2)));
        $this->assertTrue($v->validate(new \stdClass()));
        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNotValidatorThirdParam()
    {
        new ValidationCombo(new v\NotEmptyValidator(), new v\AlphaValidator(), new \stdClass());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNotValidatorThirdParamArray()
    {
        new ValidationCombo(array(
            new v\NotEmptyValidator(),
            new v\AlphaValidator(),
            new \stdClass()
        ));
    }

}
