<?php

namespace Andreracodex\Tripay\Exceptions;

use Exception;

class InvalidConfig extends Exception
{
    public static function missingApiKey()
    {
        return new static('You must specify the tripay api_key config value');
    }

    public static function missingMerchantCode()
    {
        return new static('You must specify the tripay merchant_code config value');
    }

    public static function missingPrivateKey()
    {
        return new static('You must specify the tripay private_key config value');
    }
}