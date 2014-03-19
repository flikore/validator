---
layout: default
overview: true
---

<div class="jumbotron">

<h1>Flikore Validator</h1>

<h2>A simple validation library</h2>

<p><em>Flikore Validator</em> is a validation library for PHP aimed to be simple, powerful, object oriented and extensible. It also focus on code and objects reuse, both in the library itself and in the projects that rely on the Validator.</p>
<p><a href="{{ site.baseurl }}/download.html" class="btn btn-primary" title="Download">Get it now!</a></p>

</div>

There are many others validators for PHP, of course. [Respect/Validation](https://github.com/Respect/Validation), for example, is very thorough and has a lot of validators ready to be used. The system for error messages, however, is problematic and was one of the reasons for Flikore Validator to arise. [Valitron](https://github.com/vlucas/valitron) is very simple and minimalistic, but it validates only arrays (not single values) and doesn't work with objects like Respect and Flikore do.

### How to use

To show how simple it is to use, see the following example:

{% highlight php %}
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
{% endhighlight %}

For more examples and information, see the [usage page]({{ site.baseurl }}/usage.html).

### How to install

For information about download and installation, please check the [download page]({{ site.baseurl }}/download.html).

### Extensibility

New validators can be added simply by extending the base class.

{% highlight php %}
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

{% endhighlight %}

## Contributing

Flikore Validator is an open source project and, for now, maintained by a single person ([George Marques](https://github.com/vnen)). If you want to help, there are many ways to do so.

The easiest way is to open an [issue on GitHub](https://github.com/flikore/validator/issues). It'll be checked soon and updated within reason. There are some personal goals to this project, so not all suggestions can be achieved.

If you are a developer and want to contribute with code, first understand that this project follows the [TDD](http://en.wikipedia.org/wiki/Test-driven_development "Test-driven development") practice, so you need to ship your code with the unit tests. After that, just send a [pull request on GitHub](https://github.com/flikore/validator/pulls) and it'll be looked.