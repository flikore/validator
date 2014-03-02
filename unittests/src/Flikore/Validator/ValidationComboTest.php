<?php

namespace Flikore\Validator;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2014-03-02 at 19:01:50.
 */
class ValidationComboTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ValidationCombo
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ValidationCombo;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    public function testComboValidationSuccess()
    {
        $v = $this->object;
        $v->addValidator(new MinValueValidator(5));
        $v->addValidator(new MaxValueValidator(9));

        $this->assertTrue($v->validate(5));
        $this->assertTrue($v->validate(6));
        $this->assertTrue($v->validate(7));
        $this->assertTrue($v->validate(8));
        $this->assertTrue($v->validate(9));
    }

    /**
     * @expectedException Flikore\Validator\Exception\ValidatorException
     */
    public function testComboValidationFailure()
    {
        $v = $this->object;
        $v->addValidator(new MinValueValidator(9));
        $v->addValidator(new MaxValueValidator(5));

        ($v->assert(5));
        ($v->assert(6));
        ($v->assert(7));
        ($v->assert(8));
        ($v->assert(9));
    }

    public function testAddKeyValue()
    {
        $v = $this->object;
        $a = new ExactValueValidator(5);

        $msgA = 'msgA';

        $v->addValidator($a);
        $v->addKeyValue('key', $msgA);

        $tst = false;

        $this->setExpectedException('Flikore\Validator\Exception\ValidatorException', $a->getErrorMessage());

        $v->assert(0);
    }

}
