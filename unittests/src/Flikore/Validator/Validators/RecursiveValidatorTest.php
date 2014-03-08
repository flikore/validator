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
 * Tests for RecursiveValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class RecursiveValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidationPass()
    {
        $v = new RecursiveValidator(new NotEmptyValidator());

        $ok = array('this', 'is', 'ok');

        $this->assertTrue($v->validate($ok));
    }

    public function testValidationFails()
    {
        $v = new RecursiveValidator(new NotEmptyValidator());

        $ok = array('this', 'is', 'ok', 'but', 'the', 'last', '');

        $this->assertFalse($v->validate($ok));
    }

    public function testValidationEmpty()
    {
        $v = new RecursiveValidator(new NumericValidator());

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
        $this->assertTrue($v->validate(array()));
    }

    public function testErrorKey()
    {
        $v = new RecursiveValidator(new NumericValidator());

        $notOk = array(
            'ok1'   => 1,
            'notOk' => 'oops',
            'ok2'   => 2,
        );

        $v->setErrorMessage('%arrKey%');
        $v->validate($notOk);

        $this->assertEquals('notOk', $v->getErrorMessage());
    }

}
