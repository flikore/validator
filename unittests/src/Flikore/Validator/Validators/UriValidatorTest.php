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
 * Tests for UriValidator class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.4.0
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class UriValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $v = new UriValidator();

        $this->assertTrue($v->validate('http://georgemarques.com.br'));
        $this->assertTrue($v->validate('http://flikore.github.io/validator'));
        $this->assertTrue($v->validate('https://example.com'));
        $this->assertTrue($v->validate('ftp://example.com'));
        $this->assertTrue($v->validate('ssh://192.168.1.1'));
    }

    public function testValidateFail()
    {
        $v = new UriValidator();

        $this->assertFalse($v->validate('notaulr'));
        $this->assertFalse($v->validate('   http://spacesaroundaddress.com   '));
        $this->assertFalse($v->validate('www.spacesinsideaddress .example.com'));
        $this->assertFalse($v->validate('email@example.com'));
    }

    public function testValidateEmptyValue()
    {
        $v = new UriValidator();

        $this->assertTrue($v->validate(''));
        $this->assertTrue($v->validate(null));
    }

    public function testValidateProtocolsSuccess()
    {
        $v = new UriValidator(array('http', 'https'));
        $this->assertTrue($v->validate('http://georgemarques.com.br'));
        $this->assertTrue($v->validate('http://flikore.github.io/validator'));
        $this->assertTrue($v->validate('https://example.com'));

        $v = new UriValidator('http');
        $this->assertTrue($v->validate('http://georgemarques.com.br'));
    }

    public function testValidateProtocolsFail()
    {
        $v = new UriValidator(array('http', 'https'));
        $this->assertFalse($v->validate('ftp://example.com'));
        $this->assertFalse($v->validate('ssh://192.168.1.1'));

        $v = new UriValidator('http');
        $this->assertFalse($v->validate('https://example.com'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidProtocolObject()
    {
        $v = new UriValidator(new \stdClass());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidProtocolEmptyArray()
    {
        $v = new UriValidator(array());
    }

}
