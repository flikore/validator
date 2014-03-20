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

// Build a new set of rules
$set = new \Flikore\Validator\ValidationSet(array(
    'user_name' => array(
        new v\NotEmptyValidator(),
        new v\MinLengthValidator(5),
    ),
    'user_age'  => new v\MinValueValidator(13),
        ), 
    // Add labels to make them pretty
    array(
        'user_name' => 'Name',
        'user_age'  => 'Age',
));

try
{
    // Assert some array (or object)
    $set->assert(array('user_name' => 'oops', 'user_age' => 10));
}
catch (Exception\ValidatorException $e)
{
    // Get the message of each error
    foreach ($e->getErrors() as $key => $innerException)
    {
        echo $key . ': ' . $innerException->getMessage() . PHP_EOL;
    }
    // Alternative: use the getMessages() method.
    foreach ($e->getMessages() as $key => $value)
    {
        echo $key . ': ' . $value . PHP_EOL;
    }
    // Output:
    // user_name: The Name must have at least 5 characters.
    // user_age: The Age must be equal or greater than 13.
}