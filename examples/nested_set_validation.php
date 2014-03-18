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

require_once '../autoload.php';

use Flikore\Validator\Validators as v;

// To validate arrays inside arrays, the validation sets can be nested.
$v = new ValidationSet();

// You may add a ValidationSet as a rule to some field.
// Here, let's create a set to validate the user name and email
$inner = new ValidationSet();
// And add the rules
$inner->addRule('name', new v\AlphaValidator);
$inner->addRule('email', new v\EmailValidator);

// Then, use this as the rule for the main set.
$v->addRule('user', $inner);

// Now, take this array:
$value = array(
    'user' => array(
        'name' => 'Ok name',
        'email' =>'this_is_ok@example.com',
    )
);

// And validate it
var_dump($v->validate($value)); //bool(true)
