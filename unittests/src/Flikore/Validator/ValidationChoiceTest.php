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
 * Tests for ValidationChoice class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.1
 * @since 0.5.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class ValidationChoiceTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $v = new ValidationChoice(
                new v\NumericValidator(), new v\AlphaValidator()
        );

        $this->assertTrue($v->validate('654')); // numeric, ok
        $this->assertTrue($v->validate(654)); // numeric, ok
        $this->assertTrue($v->validate('sda')); // alpha, ok
    }

    public function testValidateFail()
    {
        $v = new ValidationChoice(
                new v\NumericValidator(), new v\AlphaValidator()
        );

        $this->assertFalse($v->validate(new \stdClass())); // object, not ok
        $this->assertFalse($v->validate('2014-12-12')); // not aplha nor numeric, not ok
    }
    
    public function testAddValidator()
    {
        $v = new ValidationChoice();
        $v->addValidator(new v\NumericValidator);
        $v->addValidator(new v\AlphaValidator);

        $this->assertTrue($v->validate('654')); // numeric, ok
        $this->assertTrue($v->validate(654)); // numeric, ok
        $this->assertTrue($v->validate('sda')); // alpha, ok
        $this->assertFalse($v->validate('sda123')); // mix, not ok
    }
    
    public function testZeroValidator()
    {
        $v = new ValidationChoice(); // no validator, anything is ok

        $this->assertTrue($v->validate('654'));
        $this->assertTrue($v->validate(654));
        $this->assertTrue($v->validate('sda'));
        $this->assertTrue($v->validate('sda123'));
        $this->assertTrue($v->validate(array(2)));
        $this->assertTrue($v->validate(new \stdClass()));
        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

    public function testMessages()
    {
        $v1 = new v\NumericValidator();
        $v1->setErrorMessage('numeric');

        $v2 = new v\AlphaValidator();
        $v2->setErrorMessage('alpha');

        $v = new ValidationChoice(
                $v1, $v2
        );

        $v->setErrorMessage('%v1%');
        $this->assertEquals($v1->getErrorMessage(), $v->getErrorMessage());

        $v->setErrorMessage('%v2%');
        $this->assertEquals($v2->getErrorMessage(), $v->getErrorMessage());
    }

    public function testSetInternalMessages()
    {
        $v1 = new v\NumericValidator();
        $v1->setErrorMessage('%custom%');

        $v2 = new v\AlphaValidator();
        $v2->setErrorMessage('%custom%');

        $v = new ValidationChoice(
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
        $v = new ValidationChoice(
                new v\NotEmptyValidator(), new v\NotEmptyValidator()
        );

        $this->assertFalse($v->validate(''));
        $this->assertFalse($v->validate(null));
    }

    public function testValidateEmpty()
    {
        $v = new ValidationChoice(
                new v\NumericValidator(), new v\AlphaValidator()
        );

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

    public function testSuccessConstructionArray()
    {
        // ok if there's no error.
        new ValidationChoice(array(
            new v\NotEmptyValidator(),
            new v\AlphaValidator()
        ));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNotValidatorThirdParam()
    {
        new ValidationChoice(new v\NotEmptyValidator(), new v\AlphaValidator(), new \stdClass());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testErrorNotValidatorThirdParamArray()
    {
        new ValidationChoice(array(
            new v\NotEmptyValidator(),
            new v\AlphaValidator(),
            new \stdClass()
        ));
    }

}
