<?php

namespace Flikore\Validator\Validators;

/**
 * Description of ExactLengthValidator
 *
 * @author George Marques <george at georgemarques.com.br>
 */
class LengthBetweenValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $val = new LengthBetweenValidator(2, 4);
        $this->assertTrue($val->validate('aa'));
        $this->assertTrue($val->validate('aaa'));
        $this->assertTrue($val->validate('aaaa'));
    }

    public function testValidateFail()
    {
        $val = new LengthBetweenValidator(2, 4);
        $this->assertFalse($val->validate('aaaaa'));
        $this->assertFalse($val->validate('a'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongMinLengthArgument()
    {
        $t = new LengthBetweenValidator('aa', 4);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongMaxLengthArgument()
    {
        $t = new LengthBetweenValidator(4, 'a');
    }

    public function testValidateEmptyValue()
    {
        $val = new LengthBetweenValidator(2, 4);
        $this->assertTrue($val->validate(''));
        $this->assertTrue($val->validate(null));
    }

}
