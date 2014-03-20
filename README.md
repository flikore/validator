# Flikore Validator

[*A simple validation library*](http://flikore.github.io/validator)

[![Build Status](https://travis-ci.org/flikore/validator.png?branch=master)](https://travis-ci.org/flikore/validator)
[![Coverage Status](https://coveralls.io/repos/flikore/validator/badge.png?branch=master)](https://coveralls.io/r/flikore/validator?branch=master)

*Flikore Validator* is a validation library for PHP aimed to be simple, powerful, object oriented and extensible. It also focus on code and objects reuse, both in the library itself and in the projects that rely on the Validator.

There are many others validators for PHP, of course. [Respect/Validation](https://github.com/Respect/Validation), for example, is very thorough and has a lot of validators ready to be used. The system for error messages, however, is problematic and was one of the reasons for Flikore Validator to arise. [Valitron](https://github.com/vlucas/valitron) is very simple and minimalistic, but it validates only arrays (not single values) and doesn't work with objects like Respect and Flikore do.

## Instalation

### Composer

[Composer](http://getcomposer.org) is the preferred method to install this validator. Simply add to your `composer.json`:

```json
{
    "require": {
        "flikore/validator": "dev-master"
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

## Contributing

Flikore Validator is an open source project and, for now, maintained by a single person ([George Marques](https://github.com/vnen)). If you want to help, there are many ways to do so.

### Issues

The easiest way is to open an [issue on GitHub](https://github.com/flikore/validator/issues). It'll be checked soon and updated within reason. There are some personal goals to this project, so not all suggestions can be achieved.

### Pull request

If you are a developer and want to contribute with code, first understand that this project follows the [TDD](http://en.wikipedia.org/wiki/Test-driven_development "Test-driven development") practice, so you need to ship your code with the unit tests. After that, just send a [pull request on GitHub](https://github.com/flikore/validator/pulls) and it'll be looked.

Check the guidelines in the `CONTRIBUTE.md` file.