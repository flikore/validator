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

require '../autoload.php';

use Flikore\Validator\Validators as v;

// Create your special class
class Tested {
    
    // Add an attribute to be tested
    public $name;
    // And it can be protected (or private) too
    protected $age;
    
    // Add a setter so we can play with
    public function setAge($age)
    {
        $this->age = $age;
    }
}

// Create a set that can validate objects (and arrays too)
$set = new ValidationSet();

// Add a single rule to a key
$set->addRule('name', new v\NotEmptyValidator());
// This rule is chained with the previous one, both must be valid
$set->addRule('name', new v\MinLengthValidator(5));

// Multiple rules can be added at once with an array
// Those rules will be *added* to the "name" key, and will not exclude the others.
$set->addRules('name', array(
    new v\MaxLengthValidator(30),
    new v\RegexValidator('/^[a-z ]+$/i'),
));

// Create the object
$t = new Tested();

// Just set the value and call validate (or assert) to check if it's ok
$t->name = 'Cool Name';
var_dump($set->validate($t)); // bool(true)

$t->name = 'aaa';
var_dump($set->validate($t)); // bool(false) The minimum length is 5

$t->name = 'aa4a5';
var_dump($set->validate($t)); // bool(false) Doesn't match regex

$t->name = '';
var_dump($set->validate($t)); // bool(false) Can't be empty

// Another way is to construct the set with all the rules:
// ***Note: Even in this way, new rules can also be added later with the add methods.
$set = new ValidationSet(array(
    'name' => array(
        new v\NotEmptyValidator(),
        new v\MinLengthValidator(5),
    ),
    'age'  => new v\MinValueValidator(13),
));

// Then validate it
$t->name = 'this is ok';
$t->setAge(14);
var_dump($set->validate($t)); // bool(true)

$t->name = 'oops';
$t->setAge(14);
var_dump($set->validate($t)); // bool(false)

$t->name = 'the age is not good';
$t->setAge(12);
var_dump($set->validate($t)); // bool(false)