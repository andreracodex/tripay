<?php

namespace Andreracodex\Tripay;

use Andreracodex\Tripay\Exceptions\CouldNotSendRequest;
use Andreracodex\Tripay\Requests\HttpClient;

class Payment
{
    /** @var string */
    const VERSION = '1.x';

    /** @var ConfigManager */
    protected $configManager;

    /** @var HttpClient */
    protected $httpClient;

    /**
     * Create new instance.
     *
     * @param  ConfigManager  $configManager
     * @param  HttpClient  $httpClient
     * @return void
     */
    public function __construct(ConfigManager $configManager, HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->configManager = $configManager;
    }

    /**
     * Override the default config.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function setConfig(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if ($key == 'merchant_code') {
                $this->configManager->set('merchant_code', $value);
            } else if ($key == 'api_key') {
                $this->configManager->set('api_key', $value);
            } else if ($key == 'private_key') {
                $this->configManager->set('private_key', $value);
            } else if ($key == 'production_mode') {
                $this->configManager->set('production_mode', $value);
            }
        }

        return $this;
    }

    /**
     * Get payment channel list
     *
     * @param  string|null  $code
     * @return mixed
     */
    public function paymentChannels(?string $code = null)
    {
        $urlParams = [];
        if (!empty($code)) {
            $urlParams = [
                'code' => strtoupper($code)
            ];
        }

        return $this->httpClient->get(BaseApi::ENDPOINT_PAYMENT_CHANNEL, $urlParams);
    }

    /**
     * Fee Calculator
     *
     * @param  int  $amount
     * @param  string|null  $paymentChannelCode
     * @return mixed
     * @throws CouldNotSendRequest
     */
    public function feeCalculator(int $amount, ?string $paymentChannelCode = null)
    {
        if ($amount <= 0) {
            throw CouldNotSendRequest::invalidAmountValue();
        }

        $urlParams['amount'] = $amount;

        if (!empty($paymentChannelCode)) {
            $urlParams['code'] = $paymentChannelCode;
        }

        return $this->httpClient->get(BaseApi::ENDPOINT_FEE_CALCULATOR, $urlParams);
    }

    /**
     * Get transactions.
     *
     * @param  array  $params
     * @return mixed
     */
    public function transactions(?array $params = null)
    {
        $urlParams = [];

        return $this->httpClient->get(BaseApi::ENDPOINT_TRANSACTION_LIST, $urlParams);
    }

    /**
     * Create a transaction.
     *
     * @param  array  $params
     * @return mixed
     */
    public function createTransaction(array $params)
    {
        $merchantRef = isset($params['merchant_ref']) ? $params['merchant_ref'] : '';
        $amount = isset($params['amount']) ? $params['amount'] : 0;
        $payload['signature'] =  Generator::makeSignature($merchantRef, $amount);

        return $this->httpClient->post(BaseApi::ENDPOINT_TRANSACTION_REQUEST, $payload);
    }

    /**
     * Set the transaction reference.
     *
     * @param  string  $reference
     * @return $this
     */
    public function transactionDetails(string $reference)
    {
        $urlParams = [
            'reference' => $reference
        ];

        return $this->httpClient->get(BaseApi::ENDPOINT_TRANSACTION_DETAIL, $urlParams);
    }
}
