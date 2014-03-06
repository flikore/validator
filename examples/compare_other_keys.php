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

// This only works with a set, because it's the only way
// to have other keys to compare with
$set = new ValidationSet();

// Add some rule
$set->addRule('key1',
        // The first argument is a dummy object (can also be a FQCN string).
        new ValidationValue(new v\EqualsValidator('dummy'),
        // The second argument is the first for the EqualsValidator constructor.
        // In this case, we want to grab the value of "key2", so we create a new
        // ValidationKey and specify "key2" as its key.
        new ValidationKey('key2'),
        // This is the third argument of ValidationValue, which will be passed as
        // the second argument to EqualsValidator constructor. This is "true", because
        // we want the comparison to be strict.
        true)
); // end addRule)

// Equal values
$ok = array(
    'key1' => 'equal',
    'key2' => 'equal',
);

var_dump($set->validate($ok)); // bool(true)

// Not equal values
$notOk = array(
    'key1' => 'equal',
    'key2' => 'not equal',
);

var_dump($set->validate($notOk)); // bool(false)

// Not strictly equal values
$notStrict = array(
    'key1' =>  5,
    'key2' => '5',
);

var_dump($set->validate($notStrict)); // bool(false)

// Also works on objects
$ok = new \stdClass();
$ok->key1 = 'equal';
$ok->key2 = 'equal';
var_dump($set->validate($ok)); // bool(true)

