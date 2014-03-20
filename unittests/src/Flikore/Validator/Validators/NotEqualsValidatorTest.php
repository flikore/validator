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
        $v = new NotEqualsValidator('aa');
        $this->assertTrue($v->validate('aaa'));

        $v = new NotEqualsValidator(0);
        $this->assertTrue($v->validate(1));
        $this->assertTrue($v->validate('1'));

        $v = new NotEqualsValidator(new \stdClass());
        $this->assertTrue($v->validate(new \ArrayIterator()));
    }

    public function testValidateFail()
    {
        $v = new NotEqualsValidator('aa');
        $this->assertFalse($v->validate('aa'));
        $this->assertFalse($v->validate(0));

        $v = new NotEqualsValidator(0);
        $this->assertFalse($v->validate(0));
        $this->assertFalse($v->validate('0'));
        $this->assertFalse($v->validate('a'));

        $v = new NotEqualsValidator(new \stdClass());
        $this->assertFalse($v->validate(new \stdClass()));
    }

    public function testValidateStrictPass()
    {
        $v = new NotEqualsValidator('aa', true);
        $this->assertTrue($v->validate('aaa'));

        $v = new NotEqualsValidator(0, true);
        $this->assertTrue($v->validate(1));
        $this->assertTrue($v->validate('0'));

        $v = new NotEqualsValidator(new \stdClass(), true);
        $this->assertTrue($v->validate(new \stdClass()));
    }
    
    public function testValidateStrictFail()
    {
        $v = new NotEqualsValidator('aa', true);
        $this->assertFalse($v->validate('aa'));

        $v = new NotEqualsValidator(0, true);
        $this->assertFalse($v->validate(0));

        $obj = new \stdClass();
        $v = new NotEqualsValidator($obj, true);
        $this->assertFalse($v->validate($obj));
    }

    public function testValidateEmptyValue()
    {
        $v = new NotEqualsValidator('any');

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

    public function testMessageKeys()
    {
        $v = new NotEqualsValidator('any', true);

        $v->setErrorMessage('%compare%');
        $this->assertEquals('any', $v->getErrorMessage());

        $v->setErrorMessage('%strict%');
        $this->assertEquals('true', $v->getErrorMessage());

        $v = new NotEqualsValidator('any', false);

        $v->setErrorMessage('%strict%');
        $this->assertEquals('false', $v->getErrorMessage());
    }

}
