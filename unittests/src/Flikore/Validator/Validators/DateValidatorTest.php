<?php

namespace Flikore\Validator\Validators;

/**
 * Description of ExactLengthValidator
 *
 * @author George Marques <george at georgemarques.com.br>
 */
class DateValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidatePass()
    {
        $date = '12-12-1988';
        $val = new DateValidator();
        $this->assertTrue($val->validate($date));
    }

    public function testValidatePassWithFormat()
    {
        $date1 = '31-03-2013';
        $date2 = '28-02-2013';
        $val = new DateValidator('d-m-Y');
        $this->assertTrue($val->validate($date1));
        $this->assertTrue($val->validate($date2));
    }
    
    public function testValidatePassWithObject()
    {
        $date = new \DateTime();
        $val = new DateValidator();
        $this->assertTrue($val->validate($date));
    }

    public function testValidateFail()
    {
        $val = new DateValidator();
        $this->assertFalse($val->validate('aaa'));
        $this->assertFalse($val->validate(25));
        $this->assertFalse($val->validate(0));
    }

    public function testValidateFailWithFormat()
    {
        $date1 = '31-3-2013';
        $date2 = '28-2-2013';
        $val = new DateValidator('d-m-Y');
        $this->assertFalse($val->validate($date1));
        $this->assertFalse($val->validate($date2));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongFormatArgument()
    {
        $t = new DateValidator(323);
    }

    public function testValidateEmptyValue()
    {
        $val = new DateValidator();
        $this->assertTrue($val->validate(''));
        $this->assertTrue($val->validate(null));
    }

}
