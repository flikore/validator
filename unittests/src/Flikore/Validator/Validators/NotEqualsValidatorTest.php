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
 * Tests for NotEqualsValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.5.1
 * @since 0.4.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class NotEqualsValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $v1 = new NotEqualsValidator('aa');
        $this->assertTrue($v1->validate('aaa'));

        $v2 = new NotEqualsValidator(0);
        $this->assertTrue($v2->validate(1));
        $this->assertTrue($v2->validate('1'));

        $v3 = new NotEqualsValidator(new \stdClass());
        $this->assertTrue($v3->validate(new \ArrayIterator()));
    }

    public function testValidateFail()
    {
        $v1 = new NotEqualsValidator('aa');
        $this->assertFalse($v1->validate('aa'));
        $this->assertFalse($v1->validate(0));

        $v2 = new NotEqualsValidator(0);
        $this->assertFalse($v2->validate(0));
        $this->assertFalse($v2->validate('0'));
        $this->assertFalse($v2->validate('a'));

        $v3 = new NotEqualsValidator(new \stdClass());
        $this->assertFalse($v3->validate(new \stdClass()));
    }

    public function testValidateStrictPass()
    {
        $v1 = new NotEqualsValidator('aa', true);
        $this->assertTrue($v1->validate('aaa'));

        $v2 = new NotEqualsValidator(0, true);
        $this->assertTrue($v2->validate(1));
        $this->assertTrue($v2->validate('0'));

        $v3 = new NotEqualsValidator(new \stdClass(), true);
        $this->assertTrue($v3->validate(new \stdClass()));
    }
    
    public function testValidateStrictFail()
    {
        $v1 = new NotEqualsValidator('aa', true);
        $this->assertFalse($v1->validate('aa'));

        $v2 = new NotEqualsValidator(0, true);
        $this->assertFalse($v2->validate(0));

        $obj = new \stdClass();
        $v3 = new NotEqualsValidator($obj, true);
        $this->assertFalse($v3->validate($obj));
    }

    public function testValidateEmptyValue()
    {
        $v = new NotEqualsValidator('any');

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

    public function testMessageKeys()
    {
        $v1 = new NotEqualsValidator('any', true);

        $v1->setErrorMessage('%compare%');
        $this->assertEquals('any', $v1->getErrorMessage());

        $v1->setErrorMessage('%strict%');
        $this->assertEquals('true', $v1->getErrorMessage());

        $v2 = new NotEqualsValidator('any', false);

        $v2->setErrorMessage('%strict%');
        $this->assertEquals('false', $v2->getErrorMessage());
    }

}
