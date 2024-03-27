<?php

namespace Andreracodex\Tripay;

use Andreracodex\Tripay\Exceptions\InvalidConfig;

class Generator
{
    public static function makeSignature(string $merchantRef, int $amount)
    {
        if (empty(config('laravel-tripay.merchant_code'))) {
            throw InvalidConfig::missingMerchantCode();
        }

        if (empty(config('laravel-tripay.private_key'))) {
            throw InvalidConfig::missingPrivateKey();
        }

        $merchantCode = config('laravel-tripay.merchant_code');
        $privateKey = config('laravel-tripay.private_key');

        return hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey);
    }
}