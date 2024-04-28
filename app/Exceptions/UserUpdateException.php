<?php

namespace App\Exceptions;

use Exception;

class UserUpdateException extends Exception
{
    public function __construct($message)
    {
        $this->message = $message;
//        parent::__construct();
    }

}