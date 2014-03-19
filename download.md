---
layout: default
download: true
menu: true
title: Download
---

# Download

## Composer

[Composer](http://getcomposer.org) is the preferred method to install Flikore Validator. Simply add to your `composer.json`:

{% highlight json %}
{
    "require": {
        "flikore/validator": "dev-master"
    }
}
{% endhighlight %}

Run `composer install`, then include the autoload file in your project:

{% highlight php %}
<?php

require_once 'vendor/autoload.php';

// Do validation stuff
{% endhighlight %}

## Installing with Git

* Clone this repository in a folder on your project:

{% highlight bash %}
git clone https://github.com/flikore/validator.git vendor/flikore/validator
{% endhighlight %}

* Include the `autoload.php` file in the bootstrap for your project:

{% highlight php %}
<?php
    
require_once 'vendor/flikore/validator/autoload.php';

// Do validation stuff
{% endhighlight %}

### Submodule

An alternative is to create a submodule instead of cloning the repository. This way you don't need to push this library to your own repository and can also update it more easily:

{% highlight bash %}
git submodule add https://github.com/flikore/validator.git vendor/flikore/validator
{% endhighlight %}

## Download

You can also download the [tarball](https://github.com/flikore/validator/tarball/master "tarball") (or the [zipball](https://github.com/flikore/validator/zipball/master "zipball")) and set it up in one of your project folders.