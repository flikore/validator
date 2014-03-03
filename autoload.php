<?php

require 'SplClassLoader.php';

$loader = new Flikore\Validator\SplClassLoader('Flikore\Validator', 'src');
$loader->register();