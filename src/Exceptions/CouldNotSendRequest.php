<?php

namespace Andreracodex\Tripay\Exceptions;

use Exception;

class CouldNotSendRequest extends Exception
{
    public static function invalidAmountValue()
    {
        return new static('Amount cannot be empty');
    }
}