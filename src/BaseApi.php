<?php

namespace Andreracodex\Tripay;

use Andreracodex\Tripay\Exceptions\InvalidConfig;

class BaseApi
{
    /**
     * Base URL of the API
     *
     * @var string
     */
    const BASE_URL_SANDBOX = 'https://tripay.co.id/api-sandbox/';
    const BASE_URL_PRODUCTION = 'https://tripay.co.id/api/';

    /**
     * Endpoint lists
     *
     * @var string
     */
    const ENDPOINT_PAYMENT_CHANNEL = 'merchant/payment-channel';
    const ENDPOINT_FEE_CALCULATOR = 'merchant/fee-calculator';
    const ENDPOINT_TRANSACTION_LIST = 'merchant/transactions';
    const ENDPOINT_TRANSACTION_REQUEST = 'transaction/create';
    const ENDPOINT_TRANSACTION_DETAIL = 'transaction/detail';

    /** @var ConfigManager */
    protected $configManager;

    /**
     * Create new instance.
     *
     * @param  ConfigManager  $configManager
     * @return void
     */
    public function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    /**
     * Get base url depends on $isProduction value
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return (bool)$this->configManager->get('production_mode')
            ? self::BASE_URL_PRODUCTION
            : self::BASE_URL_SANDBOX;
    }

    /**
     * Get default headers
     *
     * @return array
     * @throws InvalidConfig
     */
    public function getDefaultHeaders()
    {
        if (empty($this->configManager->get('api_key'))) {
            throw InvalidConfig::missingApiKey();
        }

        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => 'laravel-midtrans-' . Payment::VERSION,
            'Authorization' => 'Bearer ' . $this->configManager->get('api_key')
        ];
    }

    /**
     * Merge the default and incoming headers.
     *
     * @param  array  $headers
     * @return array
     */
    public function mergeHeaders(array $headers = [])
    {
        $defaultHeaders = $this->getDefaultHeaders();

        return collect(array_merge($defaultHeaders, $headers))->mapWithKeys(function ($value, $name) {
            return [$name => $value];
        })->all();
    }
}