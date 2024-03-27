<?php

namespace Andreracodex\Tripay\Requests;

use GuzzleHttp\Client;
use Andreracodex\Tripay\BaseApi;

class HttpClient
{
    /** @var GuzzleHttp/Client */
    protected $http;

    /** @var BaseApi */
    protected $baseApi;

    /** @var array */
    protected $headerOptions = [];

    /**
     * Create new instance.
     *
     * @param  BaseApi  $baseApi
     * @return void
     */
    public function __construct(BaseApi $baseApi)
    {
        $this->baseApi = $baseApi;

        $this->http = new Client([
            'base_uri' => $this->baseApi->getBaseUrl()
        ]);

        $this->headerOptions = $this->baseApi->getDefaultHeaders();
    }

    /**
     * Call the API.
     *
     * @param  string  $method
     * @param  string  $endPoint
     * @param  array  $payload
     * @param  array  $headers
     * @return mixed
     */
    public function call(string $method, string $endPoint, array $payload = [], array $headers = [])
    {
        $headerOptions = $this->baseApi->mergeHeaders($headers);

        $requestOptions = [
            'headers' => $headerOptions,
            'json' => $payload
        ];

        if ($method == 'GET' && !empty($payload)) {
            unset($requestOptions['json']);
            $requestOptions['query'] = $payload;
        }

        $response = $this->http->request($method, $endPoint, $requestOptions);

        return json_decode($response->getBody()->getContents(), false);
    }

    /**
     * Request the API with use POST method.
     *
     * @param  string  $endPoint
     * @param  array  $payload
     * @param  array  $headers
     * @return mixed
     */
    public function post(string $endPoint, array $payload = [], array $headers = [])
    {
        return $this->call('POST', $endPoint, $payload, $headers);
    }

    /**
     * Request the API with use GET method.
     *
     * @param  string  $endPoint
     * @param  array  $urlParams
     * @param  array  $headers
     * @return mixed
     */
    public function get(string $endPoint, array $urlParams = [], array $headers = [])
    {
        return $this->call('GET', $endPoint, $urlParams, $headers);
    }
}