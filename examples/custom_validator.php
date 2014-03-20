<?php

require '../autoload.php';

use Flikore\Validator\Validator;
use Flikore\Validator\Exception\ValidatorException;

// Create a custom validator by extending the base Validator class.
class PerfectSquareValidator extends Validator
{
    // Set a nice error message to it.
    public function __construct()
    {
        $this->setErrorMessage('The %key% must be a perfect square.');
    }

    // Implement the doValidate with your logic. This is used by both assert and validate methods.
    protected function doValidate($value)
    {
        // Empty values usually are ok
        if($this->isEmpty($value)) { return true; }
        
        // Valid values must return true.
        return is_numeric($value) && (floor(sqrt($value)) * floor(sqrt($value)) == ((int)$value));
    }

}

// Instantiate your custom validator.
$v = new PerfectSquareValidator();

// And test it exhaustively.
var_dump($v->validate(25));   // bool(true)
var_dump($v->validate(30));   // bool(false)
var_dump($v->validate('36')); // bool(true)

// Test the assertion too.
try
{
    $v->assert(40);
}
catch (ValidatorException $e)
{
    // And check the error message.
    echo $e->getMessage(); // "The value must be a perfect square."
}