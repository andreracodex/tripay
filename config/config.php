<?php

return [
    /**
     * Set the Merchant Code
     */
    'merchant_code' => env('TRIPAY_MERCHANT_CODE', ''),

    /**
     * Set the API Key
     */
    'api_key' => env('TRIPAY_API_KEY', ''),

    /**
     * Set the Private Key
     */
    'private_key' => env('TRIPAY_PRIVATE_KEY', ''),

    /**
     * Set the environment that currently on SANDBOX or PRODUCTION
     */
    'production_mode' => env('TRIPAY_PRODUCTION_MODE', false)
];