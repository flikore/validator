# Flikore Validator

[*A simple validation library*](http://flikore.github.io/validator)

[![Build Status](https://travis-ci.org/flikore/validator.png?branch=develop)](https://travis-ci.org/flikore/validator)
[![Coverage Status](https://coveralls.io/repos/flikore/validator/badge.png?branch=develop)](https://coveralls.io/r/flikore/validator?branch=develop)

*Flikore Validator* is a validation library for PHP aimed to be simple, powerful, object oriented and extensible. It also focus on code and objects reuse, both in the library itself and in the projects that rely on the Validator.

There are many others validators for PHP, of course. [Respect/Validation](https://github.com/Respect/Validation), for example, is very thorough and has a lot of validators ready to be used. The system for error messages, however, is problematic and was one of the reasons for Flikore Validator to arise. [Valitron](https://github.com/vlucas/valitron) is very simple and minimalistic, but it validates only arrays (not single values) and doesn't work with objects like Respect and Flikore do.

## Instalation

### Composer

[Composer](http://getcomposer.org) is the preferred method to install this validator. Simply add to your `composer.json`:

```json
{
    "require": {
        "flikore/validator": "dev-develop"
    }
}
```

Run `composer install`, then include the autoload file in your project:

```php
<?php

require_once 'vendor/autoload.php';

// Do validation stuff
```

### Installing with Git

* Clone this repository in a folder on your project:

```
git clone https://github.com/flikore/validator.git vendor/flikore/validator
```

* Include the `autoload.php` file in the bootstrap for your project:

```php
<?php
    
require_once 'vendor/flikore/validator/autoload.php';

// Do validation stuff
```

An alternative is to create a submodule instead of cloning the repository. This way you don't need to push this library to your own repository and can also update it more easily:

```
git submodule add https://github.com/flikore/validator.git vendor/flikore/validator
```

### Download

You can also download the [tarball](https://github.com/flikore/validator/tarball/master "tarball") (or the [zipball](https://github.com/flikore/validator/zipball/master "zipball")) and set it up in one of your project folders.

## How to use

To show how simple it is to use, see the following example:

```php
<?php

require 'autoload.php';

use Flikore\Validator\Validators as v;

// Instantiate an existing validator
$v = new v\ExactValueValidator(5);

// Use the "validate" method to check if a value is valid
var_dump($v->validate(5));    // bool(true)

// And you can use the same validator object as many times as you want
var_dump($v->validate(4));    // bool(false)
var_dump($v->validate(0));    // bool(false)
```

For more examples and information, see the [usage page](http://flikore.github.io/validator/usage.html).

Also, see the examples folder, as it shows most (if not all) of the features.

### Extensibility

New validators can be added simply by extending the base class.

```php
<?php

require 'autoload.php';

use Flikore\Validator\Validators as v;

class PerfectSquareValidator extends Flikore\Validator\Validator
{
    protected function doValidate($value)
    {
        return is_numeric($value) && (floor(sqrt($value)) * floor(sqrt($value)) 
                == ((int)$value));
    }

}

$v = new PerfectSquareValidator();

var_dump($v->validate(25));   // bool(true)
var_dump($v->validate(30));   // bool(false)
var_dump($v->validate('36')); // bool(true)

```

## Available validators

Currently, there are the following validator classes (click to see the API documentation):

* [AfterDateTimeValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.AfterDateTimeValidator.html "AfterDateTimeValidator")
* [AlphaNumericValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.AlphaNumericValidator.html "AlphaNumericValidator")
* [AlphaValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.AlphaValidator.html "AlphaValidator")
* [BeforeDateTimeValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.BeforeDateTimeValidator.html "BeforeDateTimeValidator")
* [DateTimeValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.DateTimeValidator.html "DateTimeValidator")
* [DateValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.DateValidator.html "DateValidator") *(deprecated)*
* [EmailValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.EmailValidator.html "EmailValidator")
* [EqualsValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.EqualsValidator.html "EqualsValidator")
* [ExactLengthValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.ExactLengthValidator.html "ExactLengthValidator")
* [ExactValueValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.ExactValueValidator.html "ExactValueValidator")
* [GreaterThanValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.GreaterThanValidator.html "GreaterThanValidator")
* [IPv4Validator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.IPv4Validator.html "IPv4Validator")
* [IPv6Validator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.IPv6Validator.html "IPv6Validator")
* [InstanceOfValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.InstanceOfValidator.html "InstanceOfValidator")
* [LengthBetweenValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.LengthBetweenValidator.html "LengthBetweenValidator")
* [LessThanValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.LessThanValidator.html "LessThanValidator")
* [LetterNumericValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.LetterNumericValidator.html "LetterNumericValidator")
* [LetterValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.LetterValidator.html "LetterValidator")
* [MaxDateTimeValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.MaxDateTimeValidator.html "MaxDateTimeValidator")
* [MaxLengthValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.MaxLengthValidator.html "MaxLengthValidator")
* [MaxValueValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.MaxValueValidator.html "MaxValueValidator")
* [MinAgeValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.MinAgeValidator.html "MinAgeValidator")
* [MinDateTimeValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.MinDateTimeValidator.html "MinDateTimeValidator")
* [MinLengthValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.MinLengthValidator.html "MinLengthValidator")
* [MinValueValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.MinValueValidator.html "MinValueValidator")
* [NoSpaceValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.NoSpaceValidator.html "NoSpaceValidator")
* [NotEmptyValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.NotEmptyValidator.html "NotEmptyValidator")
* [NotEqualsValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.NotEqualsValidator.html "NotEqualsValidator")
* [NumericValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.NumericValidator.html "NumericValidator")
* [OrValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.OrValidator.html "OrValidator") *(deprecated)*
* [RecursiveValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.RecursiveValidator.html "RecursiveValidator")
* [RegexValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.RegexValidator.html "RegexValidator")
* [UriValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.UriValidator.html "UriValidator")
* [ValueBetweenValidator](http://flikore.github.io/validator/api/master/class-Flikore.Validator.Validators.ValueBetweenValidator.html "ValueBetweenValidator")

## Contributing

Flikore Validator is an open source project and, for now, maintained by a single person ([George Marques](https://github.com/vnen)). If you want to help, there are many ways to do so.

### Issues

The easiest way is to open an [issue on GitHub](https://github.com/flikore/validator/issues). It'll be checked soon and updated within reason. There are some personal goals to this project, so not all suggestions can be achieved.

### Pull request

If you are a developer and want to contribute with code, first understand that this project follows the [TDD](http://en.wikipedia.org/wiki/Test-driven_development "Test-driven development") practice, so you need to ship your code with the unit tests. After that, just send a [pull request on GitHub](https://github.com/flikore/validator/pulls) and it'll be looked.

Check the guidelines in the `CONTRIBUTE.md` file.