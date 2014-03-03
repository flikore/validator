<?php

namespace Flikore\Validator\Validators;

/**
 * Description of ExactLengthValidator
 *
 * @author George Marques <george at georgemarques.com.br>
 */
class MinLengthValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $val = new MinLengthValidator(2);
        $this->assertTrue($val->validate('aa'));
        $this->assertTrue($val->validate('aaaa'));
        $this->assertTrue($val->validate('aaasdadad'));
    }

    public function testValidateFail()
    {
        $val = new MinLengthValidator(3);
        $this->assertFalse($val->validate('a'));
        $this->assertFalse($val->validate('aa'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongLengthArgument()
    {
        $t = new MinLengthValidator('aa');
    }

    public function testValidateEmptyValue()
    {
        $val = new MinLengthValidator(2);
        $this->assertTrue($val->validate(''));
        $this->assertTrue($val->validate(null));
    }

}
