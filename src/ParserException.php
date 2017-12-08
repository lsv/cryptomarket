<?php

namespace App;

class ParserException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
