<?php

require 'SplClassLoader.php';

$loader = new SplClassLoader('Flikore\Validator', 'src');
$loader->register();