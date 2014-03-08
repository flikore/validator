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

// Recursive check every element in an array against a validator
// Use the RecursiveValidator class.
$v = new v\RecursiveValidator(new v\NotEmptyValidator);

// Example array
$ok = array(
    'this',
    'is',
    'ok'
);

var_dump($v->validate($ok)); // bool(true)

// Another example
$notOk = array(
    'this',
    'is',
    'not',
    'ok',
    'oops' => '', //<- this is empty
);

var_dump($v->validate($notOk)); // bool(false)

// To get the key where there was an error, use the %arrKey% template
$v->setErrorMessage('The key "%arrKey%" is empty.');
echo $v->getErrorMessage(); // prints: The key "oops" is empty.