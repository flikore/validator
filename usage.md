---
layout: default
menu: true
usage: true
title: Basic usage
---

# Basic usage

## Basic value validation

{% highlight php %}
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
{% endhighlight %}

The validators ignores null values and empty strings. If you like to make sure a value is not empty, use the NotEmptyValidator.

{% highlight php %}
<?php

use Flikore\Validator\Validators as v;

$v = new v\NotEmptyValidator();

var_dump($v->validate(null));    // bool(false)
var_dump($v->validate(array())); // bool(false)
var_dump($v->validate(''));      // bool(false)
var_dump($v->validate(0));       // bool(true)
{% endhighlight %}

## Multiple validators

If you want to check if multiple conditions apply, use the `ValidatorCombo` class. It can join any number and validators and act as a validator itself (so it can also be use in other `ValidationCombo`).

{% highlight php %}
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
{% endhighlight %}

## Recursive validation

To apply a validator to every element in an array, use the `RecursiveValidator` class. It receives one validator in the constructor and checks the elements with such validator.

{% highlight php %}
<?php

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
{% endhighlight %}

## Usage with exceptions

To throw an exception on a validation error, use the `assert` method instead of `validate`. It throws a `ValidationException` with a custom message for each validator.

{% highlight php %}
<?php

use Flikore\Validator\Validators as v;

$v = new v\ExactValueValidator(5);

// Throws a ValidationException with the message:
// "The value must be exactly 5."
$v->assert(2);
{% endhighlight %}

### Custom messages

The message of the exception can be set on the validator using the method `setErrorMessage()`. If the validator is a Combo, then the message setted with this method will be the message shown to any validation error (to avoid this behavior, set the messages of the validators *inside* the combo).

Each validator has a set of values that can be used in the message. The value named `key` exists in all validator and defaults to `"value"`. Those keys replace the sequence `%key%` inside the message. To override a default value of a key, use the `addKeyValue` method (this can be used to set the `key` as the name of the form field, for example).

**Example**:
{% highlight php %}
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
{% endhighlight %}

## Validating arrays and objects

The `ValidationSet` class can be used as a shortcut to test all the values in an array or the properties of an object all at once. The usage is pretty straightforward:

{% highlight php %}
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

var_dump($set->validate(array('name' => 'this is ok',          'age' => 14))); // bool(true)
var_dump($set->validate(array('name' => 'oops',                'age' => 14))); // bool(false)
var_dump($set->validate(array('name' => 'the age is not good', 'age' => 12))); // bool(false)
{% endhighlight %}

If you need to validate only a subset of fields (for, say, using in the `onBlur` event of an input element, without need to validate the whole form), set the second argument of `validate` (or `assert`) to the field or list of fields you want to actually validate. If there's no rules for a given field, it'll just be ignored.

**Example**:

{% highlight php %}
<?php

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
{% endhighlight %}

### Comparing with other keys

It's also possible to use another key or attribute as the input value for a validator (e.g. validate if one field is equal to another). To do that, you need to use two other classes combined: `ValidationValue` and `ValidationKey`.

`ValidationValue` should be included in a set as it were a validator. Its constructor requires a validator as the first argument (can be a string with a FQCN or a dummy validator object) and the arguments to the validator constructor must follow it. To use a field from the validated object in the constructor, pass it as a `ValidationKey` object with it's key property being the name of the attribute or key you want to grab from the value being validated.

Let's make that clear with and example. To make sure the value of `key1` is strictly equal to the value of `key2` inside the same array, do like the following code:

{% highlight php %}
<?php

use Flikore\Validator\ValidationKey;
use Flikore\Validator\ValidationSet;
use Flikore\Validator\ValidationValue;
use Flikore\Validator\Validators as v;

$set = new ValidationSet();

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

$ok = array(
    'key1' => 'equal',
    'key2' => 'equal',
);

var_dump($set->validate($ok)); // bool(true)

$notOk = array(
    'key1' => 'equal',
    'key2' => 'not equal',
);

var_dump($set->validate($notOk)); // bool(false)

$notStrict = array(
    'key1' =>  5,
    'key2' => '5',
);

var_dump($set->validate($notStrict)); // bool(false)
{% endhighlight %}

Keep in mind that the values that are passed to the validator are not checked in the `ValidationValue` constructor. So if there's something wrong, it'll only cause an error when the validation is taking place and the real `Validator` is constructed.

**Note**: this doesn't work with `ValidationCombo`, but since you can add multiple rules to the same key, this should not be a problem.

### Sets and exceptions

With a `ValidationSet`, exception messages work in a different way than with a `Validator`. The main exception has no message attached, but it contains an array of errors with the keys being the validated array keys (or object properties) and the values being the child validator exception.

Also, the key name you add to the set is also setted as the `%key%` template value in the error messages. To change that to another value, use the third argument of `addRule` and `addRules` methods with the value you want). This can be used if you want to change the language of the message or to specify a more user friendly form label.

**Example**:

{% highlight php %}
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
    foreach ($e->getErrors() as $key => $innerException)
    {
        echo $key . ': ' . $innerException->getMessage() . PHP_EOL;
    }
    // Output:
    // user_name: The Name must have at least 5 characters.
    // user_age: The Age must be equal or greater than 13.
}
{% endhighlight %}

### Nested arrays

To validate arrays inside arrays, it is possible to nest `ValidationSet` as a rule. So, in theory, there's no limit to how much levels you can nest.

**Example**:

{% highlight php %}
<?php

use Flikore\Validator\Validators as v;
use Flikore\Validator\ValidationSet;

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
{% endhighlight %}