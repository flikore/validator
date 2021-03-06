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

// Create a set of rules.
$set = new ValidationSet(array(
    'name'  => array(
        new v\NotEmptyValidator(),
        new v\MinLengthValidator(5),
    ),
    'age'   => new v\MinValueValidator(13),
    'email' => new v\EmailValidator(),
));

// Creating a value
$value = array(
    'name'    => 'this is ok',
    'age'     => 12, // not ok
    'email'   => 'this_is_ok@example.com',
    'no_rule' => 'whatever',
);

// Validates only the name, so it's ok
var_dump($set->validate($value, 'name')); // bool(true)
// Validates the name and email
var_dump($set->validate($value, array('name', 'email'))); // bool(true)
// Validates the no_rule
var_dump($set->validate($value, 'no_rule')); // bool(true)
// Validates the name and age, so there's error
var_dump($set->validate($value, array('name', 'age'))); // bool(false)