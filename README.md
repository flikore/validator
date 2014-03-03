# Flikore Validator

*A simple validation library*.

Flikore validator is a validation library for PHP aimed to be simple and extensible.

## Instalation

* Clone this repository in a folder on your project:

```
git clone https://github.com/flikore/validator.git vendor/flikore/validator
```

* Include the `autoload.php` file in the bootstrap for your project:

```php
<?php
    
require_once 'vendor/flikore/validator/autoload.php';
```

An alternative is to create a submodule instead of cloning the repository. This way you don't need to push this library to your own repository and can also update it more easily:

```
git submodule add https://github.com/flikore/validator.git vendor/flikore/validator
```

## Usage

### Basic value validation

```php
<?php

use Flikore\Validator\Validators as v;

// Instantiate an existing validator
$v = new v\ExactValueValidator(5);

// Use the "validate" method to check if a value is valid
var_dump($v->validate(5));    // bool(true)
var_dump($v->validate(4));    // bool(false)
var_dump($v->validate(0));    // bool(false)
var_dump($v->validate(null)); // bool(true)
var_dump($v->validate(''));   // bool(true)
```

The validators ignores null values and empty strings. If you like to make sure a value is not empty, use the NotEmptyValidator.

```php
<?php

use Flikore\Validator\Validators as v;

$v = new v\NotEmptyValidator();

var_dump($v->validate(null));    // bool(false)
var_dump($v->validate(array())); // bool(false)
var_dump($v->validate(''));      // bool(false)
var_dump($v->validate(0));       // bool(true)
```

### Multiple validators

If you want to check if multiple conditions apply, use the `ValidatorCombo` class. It can join any number and validators and act as a validator itself (so it can also be use in other `ValidationCombo`).

```php
<?php

use Flikore\Validator\Validators as v;

$combo = new Flikore\Validator\ValidationCombo();

$combo->addValidator(new v\ExactLengthValidator(5));
$combo->addValidator(new v\NotEmptyValidator());

var_dump($combo->validate('12345'));  // bool(true)
var_dump($combo->validate('1234'));   // bool(false)
var_dump($combo->validate('123456')); // bool(false)
var_dump($combo->validate(''));       // bool(false)
var_dump($combo->validate(null));     // bool(false)
var_dump($combo->validate(''));       // bool(false)
```

### Usage with exceptions

To throw an exception on a validation error, use the `assert` method instead of `validate`. It throws a `ValidationException` with a custom message for each validator.

```php
<?php

use Flikore\Validator\Validators as v;

$v = new v\ExactValueValidator(5);

// Throws a ValidationException with the message:
// "The value must be exactly 5."
$v->assert(2);
```

#### Custom messages

The message of the exception can be set on the validator using the method `setErrorMessage()`. If the validator is a Combo, then the message setted with this method will be the message shown to any validation error (to avoid this behavior, set the messages of the validators *inside* the combo).

Each validator has a set of values that can be used in the message. The value named `key` exists in all validator and defaults to `"value"`. Those keys replace the sequence `%key%` inside the message. To override a default value of a key, use the `addKeyValue` method (this can be used to set the `key` as the name of the form field, for example).

**Example**:
```php
<?php

use Flikore\Validator\Validators as v;

$v = new v\ExactLengthValidator(5);

// Setting a new message template
$v->setErrorMessage('The %key% is not %length% %c% long as it should be.');

// Override the default key name
$v->addKeyValue('key', 'input');
// Create a custom key
$v->addKeyValue('c', 'characters');

// Captures the error
try
{
    $v->assert('Name');
}
catch (Flikore\Validator\Exception\ValidatorException $e)
{
    echo $e->getMessage(); // Shows "The input is not 5 characters long as it should be."
}
```

### Validating arrays and objects

The `ValidationSet` class can be used as a shortcut to test all the values in an array or the properties of an object all at once. The usage is pretty straightforward:

```php
<?php

use Flikore\Validator\Validators as v;

$set = new \Flikore\Validator\ValidationSet();

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

// Just call validate (or assert) to check if it's ok
var_dump($set->validate(array('name' => 'Cool Name'))); // bool(true)
var_dump($set->validate(array('name' => 'aaa')));       // bool(false) The minimum length is 5
var_dump($set->validate(array('name' => 'aa4a5')));     // bool(false) Doesn't match regex
var_dump($set->validate(array('name' => '')));          // bool(false) Can't be empty

// Another way is to construct the set with all the rules:
// ***Note: Even in this way, new rules can also be added later with the add methods.
$set = new \Flikore\Validator\ValidationSet(array(
    'name' => array(
        new v\NotEmptyValidator(),
        new v\MinLengthValidator(5),
    ),
    'age'  => new v\MinValueValidator(13),
));

var_dump($set->validate(array('name' => 'this is ok', 'age' => 14))); // bool(true)
var_dump($set->validate(array('name' => 'oops',       'age' => 14))); // bool(false)
var_dump($set->validate(array('name' => 'this is ok', 'age' => 12))); // bool(false)
```

#### Sets and exceptions

With a `ValidationSet`, exception messages work in a different way. The main exception has no message attached, but it contains an array of errors with the keys being the validated array keys (or object properties) and the values being the child validator exception.

Also, the key name you add to the set is also setted as the `%key%` template value in the error messages. To change that to another value, use the third argument of `addRule` and `addRules` methods with the value you want). This can be used if you want to change the language of the message or to specify a more user friendly form label.

**Example**:

```php
<?php

use Flikore\Validator\Validators as v;

$set = new \Flikore\Validator\ValidationSet(array(
    'user_name' => array(
        new v\NotEmptyValidator(),
        new v\MinLengthValidator(5),
    ),
    'user_age'  => new v\MinValueValidator(13),
        ), 
    // Labels:
    array(
        'user_name' => 'Name',
        'user_age'  => 'Age',
));

try
{
    $set->assert(array('user_name' => 'oops', 'user_age' => 10));
}
catch (Flikore\Validator\Exception\ValidatorException $e)
{
    foreach ($e->getErrors() as $key => $value)
    {
        echo $key . ': ' . $value->getMessage() . PHP_EOL;
    }
    // Output:
    // user_name: The Name must have at least 5 characters.
    // user_age: The Age must be equal or greater than 13.
}
```