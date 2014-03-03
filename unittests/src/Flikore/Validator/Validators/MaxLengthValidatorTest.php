<?php

namespace Flikore\Validator\Validators;

/**
 * Description of ExactLengthValidator
 *
 * @author George Marques <george at georgemarques.com.br>
 */
class MaxLengthValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $val = new MaxLengthValidator(5);
        $this->assertTrue($val->validate('a'));
        $this->assertTrue($val->validate('aaa'));
        $this->assertTrue($val->validate('aaasa'));
    }

    public function testValidateFail()
    {
        $val = new MaxLengthValidator(3);
        $this->assertFalse($val->validate('aaaaa'));
        $this->assertFalse($val->validate('aaaaaaaasdasdaddd'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongLengthArgument()
    {
        $t = new MaxLengthValidator('aa');
    }

    public function testValidateEmptyValue()
    {
        $val = new MaxLengthValidator(5);
        $this->assertTrue($val->validate(''));
        $this->assertTrue($val->validate(null));
    }

}
