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

// Instantiate an existing validator
$v = new v\ExactValueValidator(5);

// Use the "validate" method to check if a value is valid
var_dump($v->validate(5));    // bool(true)
var_dump($v->validate(4));    // bool(false)
var_dump($v->validate(0));    // bool(false)

// It ignores empty values
var_dump($v->validate(null));    // bool(true)
var_dump($v->validate(''));      // bool(true)
// But "zero" is not empty
var_dump($v->validate(0));       // bool(false)
// Nor is "false"
var_dump($v->validate(false));   // bool(false)
// As nor is an empty array
var_dump($v->validate(array())); // bool(false)

// And "false" is equal to "zero"
$v = new v\ExactValueValidator(0);
var_dump($v->validate(false));   // bool(true)