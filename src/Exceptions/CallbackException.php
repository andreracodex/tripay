<?php

namespace Andreracodex\Tripay\Exceptions;

use Exception;

class CallbackException extends Exception
{
    public static function invalidSignature()
    {
        return new static('Invalid callback signature');
    }

    public static function invalidCallbackEvent()
    {
        return new static('Invalid callback event, no action was taken');
    }
}