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

namespace Flikore\Validator;

/**
 * This is class is just for the test of ValidationSet with a class implementing ArrayAccess
 */
class ArrayAccessTestingImplementation implements \ArrayAccess
{

    protected $notEmpty;

    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    public function offsetUnset($offset)
    {
        
    }

}

/**
 * Tests for ValidationSet class.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @version 0.4.0
 * @since 0.1
 * @license http://opensource.org/licenses/MIT MIT
 * @copyright (c) 2014, George Marques
 * @package Flikore\Validator
 * @category Tests
 */
class ValidationSetTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ValidationSet
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ValidationSet();
    }

    public function testAddRule()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $this->assertTrue($this->object->validate(array('notEmpty' => 'Something')));
        $this->assertFalse($this->object->validate(array('notEmpty' => '')));
    }

    public function testAddRules()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRules('notEmpty', array($r));

        $this->assertTrue($this->object->validate(array('notEmpty' => 'Something')));
        $this->assertFalse($this->object->validate(array('notEmpty' => '')));
    }

    public function testConstructWithRules()
    {
        $r = new Validators\NotEmptyValidator();
        $v = new ValidationSet(array(
            'notEmpty'     => $r,
            'alsoNotEmpty' => array($r),
        ));

        $this->assertTrue($v->validate(array('notEmpty' => 'Something', 'alsoNotEmpty' => 'Another thing')));
        $this->assertFalse($v->validate(array('notEmpty' => '', 'alsoNotEmpty' => 'Another thing')));
        $this->assertFalse($v->validate(array('notEmpty' => 'Something', 'alsoNotEmpty' => '')));
        $this->assertFalse($v->validate(array('notEmpty' => '', 'alsoNotEmpty' => '')));
    }

    public function testValidateFail()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $this->assertFalse($this->object->validate(array('notEmpty' => '')));
    }

    public function testValidateSuccess()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $this->assertTrue($this->object->validate(array('notEmpty' => 'Something')));
        $this->assertTrue($this->object->validate(array('notEmpty' => 'Another thing')));
    }

    public function testAssertSuccess()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        // Ok as long as it doesn't raise an exeception.
        $this->object->assert(array('notEmpty' => 'aa'));
    }

    /**
     * @expectedException Flikore\Validator\Exception\ValidatorException
     */
    public function testAssertFail()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $this->object->assert(array('notEmpty' => ''));
    }

    public function testGetKeyValueFromObject()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $obj = new \stdClass();
        $obj->notEmpty = 'not';

        $this->assertTrue($this->object->validate($obj));

        $obj->notEmpty = null;

        $this->assertFalse($this->object->validate($obj));
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testGetInvalidKeyValueFromObject()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $obj = new \stdClass();
        $obj->notEmptyWrong = 'not';

        $this->assertTrue($this->object->validate($obj));
    }

    public function testGetKeyValueFromArrayObject()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $obj = new ArrayAccessTestingImplementation();

        $obj['notEmpty'] = 'Something';

        $this->assertTrue($this->object->validate($obj));

        $obj['notEmpty'] = null;

        $this->assertFalse($this->object->validate($obj));
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testGetInvalidKeyValueFromArray()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $arr = array('notEmptyWrong' => 'not');

        $this->object->validate($arr);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetInvalidKeyNoObjectOrArray()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $this->object->validate('invalid');
    }

    public function testValidationValue()
    {
        $this->object->addRule('field1', new ValidationValue(new Validators\EqualsValidator('dummy'), new ValidationKey('field2')));

        $value = array(
            'field1' => 'equal',
            'field2' => 'equal',
        );

        $value2 = new \stdClass();
        $value2->field1 = 'also equal';
        $value2->field2 = 'also equal';

        $this->assertTrue($this->object->validate($value));
        $this->assertTrue($this->object->validate($value2));
    }

    public function testValidationValueAssert()
    {
        $this->object->addRule('field1', new ValidationValue(new Validators\EqualsValidator('dummy'), new ValidationKey('field2')));

        $value = array(
            'field1' => 'equal',
            'field2' => 'equal',
        );

        $value2 = new \stdClass();
        $value2->field1 = 'also equal';
        $value2->field2 = 'also equal';

        // Ok as long as it doesn't raise an exeception.
        $this->object->assert($value);
        $this->object->assert($value2);
    }

    public function testAddKeyValue()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $this->object->addKeyValue('test', 'this is test');
        $r->setErrorMessage('%test%');

        $this->assertEquals('this is test', $r->getErrorMessage());
    }

    public function testAddKeyValueWithObject()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addRule('notEmpty', $r);

        $this->object->addKeyValue('test', new \stdClass());
        $r->setErrorMessage('%test%');

        $this->assertEquals('stdClass', $r->getErrorMessage());
    }

    public function testKeyValueAddingRule()
    {
        $r = new Validators\NotEmptyValidator();

        $this->object->addKeyValue('test', 'this is test');

        $this->object->addRule('notEmpty', $r);
        $r->setErrorMessage('%test%');

        $this->assertEquals('this is test', $r->getErrorMessage());
    }

    public function testKeyValueAddingRules()
    {
        $r1 = new Validators\NotEmptyValidator();
        $r2 = new Validators\NumericValidator();

        $this->object->addKeyValue('test', 'this is test');

        $this->object->addRules('field', array($r1, $r2));

        $r1->setErrorMessage('%test%');
        $r2->setErrorMessage('%test%');

        $this->assertEquals('this is test', $r1->getErrorMessage());
        $this->assertEquals('this is test', $r2->getErrorMessage());
    }

    public function testGetRuleFor()
    {
        $r1 = new Validators\NotEmptyValidator();
        $r2 = new Validators\NumericValidator();

        $this->assertTrue(is_array($this->object->getRulesFor('field', array($r1, $r2))));
        $this->assertEmpty($this->object->getRulesFor('field', array($r1, $r2)));

        $this->object->addRules('field', array($r1, $r2));

        $rules = $this->object->getRulesFor('field');

        $this->assertSame($r1, $rules[0]);
        $this->assertSame($r2, $rules[1]);
    }

    public function testPartialValidationSuccess()
    {
        $r1 = new Validators\NumericValidator();
        $r2 = new Validators\NotEmptyValidator();

        $this->object->addRule('field1', $r1);
        $this->object->addRule('field2', $r2);

        $tst = array(
            'field1' => 2,
        );

        $this->assertTrue($this->object->validate($tst, 'field1'));        // string
        $this->assertTrue($this->object->validate($tst, array('field1'))); // array        
    }

    public function testPartialValidationFail()
    {
        $r1 = new Validators\NumericValidator();
        $r2 = new Validators\NotEmptyValidator();

        $this->object->addRule('field1', $r1);
        $this->object->addRule('field2', $r2);

        $tst = array(
            'field1' => 'not numeric',
        );

        $this->assertFalse($this->object->validate($tst, 'field1'));        // string
        $this->assertFalse($this->object->validate($tst, array('field1'))); // array        
    }

    public function testPartialAssertionSuccess()
    {
        $r1 = new Validators\NumericValidator();
        $r2 = new Validators\NotEmptyValidator();

        $this->object->addRule('field1', $r1);
        $this->object->addRule('field2', $r2);

        $tst = array(
            'field1' => 2,
        );

        // ok as long as there's no exeception
        $this->object->assert($tst, 'field1');        // string
        $this->object->assert($tst, array('field1')); // array        
    }

    /**
     * @expectedException Flikore\Validator\Exception\ValidatorException
     */
    public function testPartialAssertionFailString()
    {
        $r1 = new Validators\NumericValidator();
        $r2 = new Validators\NotEmptyValidator();

        $this->object->addRule('field1', $r1);
        $this->object->addRule('field2', $r2);

        $tst = array(
            'field1' => 'not numeric',
        );

        $this->object->assert($tst, 'field1');
    }

    /**
     * @expectedException Flikore\Validator\Exception\ValidatorException
     */
    public function testPartialAssertionFailArray()
    {
        $r1 = new Validators\NumericValidator();
        $r2 = new Validators\NotEmptyValidator();

        $this->object->addRule('field1', $r1);
        $this->object->addRule('field2', $r2);

        $tst = array(
            'field1' => 'not numeric',
        );

        $this->object->assert($tst, array('field1'));
    }

    public function testPartialValidationIgnoreFieldSuccess()
    {
        $r1 = new Validators\NumericValidator();
        $r2 = new Validators\NotEmptyValidator();

        $this->object->addRule('field1', $r1);
        $this->object->addRule('field2', $r2);

        $tst = array(
            'field1' => 2,
        );

        $this->assertTrue($this->object->validate($tst, array('field1', 'notinarray')));
        $this->object->assert($tst, array('field1', 'notinarray'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPartialValidationInvalidFieldsObject()
    {
        $r1 = new Validators\NumericValidator();
        $r2 = new Validators\NotEmptyValidator();

        $this->object->addRule('field1', $r1);
        $this->object->addRule('field2', $r2);

        $tst = array(
            'field1' => 2,
        );

        $this->object->validate($tst, new \stdClass());
    }

    public function testPartialValidationIntegerKey()
    {
        $r1 = new Validators\NumericValidator();
        $r2 = new Validators\NotEmptyValidator();

        $this->object->addRule(0, $r1);
        $this->object->addRule(0, $r2);

        $tst = array(
            0 => 2,
        );

        $this->assertTrue($this->object->validate($tst, 0));        // string
        $this->assertTrue($this->object->validate($tst, array(0))); // array        
    }

}
