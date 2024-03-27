<?php

namespace Tests;

use Andreracodex\Tripay\Exceptions\InvalidConfig;
use Andreracodex\Tripay\Facades\Tripay;
use Illuminate\Foundation\Testing\WithFaker;

class ServiceProviderTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_should_be_throw_exception_if_api_key_not_provided()
    {
        $this->app['config']->set('laravel-tripay.api_key', '');

        $this->expectException(InvalidConfig::class);

        Tripay::paymentChannels();
    }
}