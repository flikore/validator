<?php

namespace Flikore\Validator\Validators;

/**
 * Description of ExactLengthValidator
 *
 * @author George Marques <george at georgemarques.com.br>
 */
class ExactLengthValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $string = 'aa';
        $val = new ExactLengthValidator(2);
        $this->assertTrue($val->validate($string));
    }

    public function testValidateFail()
    {
        $val = new ExactLengthValidator(2);
        $this->assertFalse($val->validate('aaa'));
        $this->assertFalse($val->validate('a'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongLengthArgument()
    {
        $t = new ExactLengthValidator('aa');
    }

    public function testValidateEmptyValue()
    {
        $val = new ExactLengthValidator(2);
        $this->assertTrue($val->validate(''));
    }

}
