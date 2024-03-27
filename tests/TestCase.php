<?php

namespace Tests;

use Andreracodex\Tripay\Facades\Tripay;
use Andreracodex\Tripay\TripayServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

abstract class TestCase extends TestbenchTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            TripayServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Tripay' => Tripay::class
        ];
    }
}