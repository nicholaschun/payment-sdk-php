<?php

namespace Nicholaschun\PaymentSDK\Tests;

use Nicholaschun\PaymentSDK\PaymentSDKServiceProvider;
use Spatie\LaravelData\Normalizers\ArrayableNormalizer;
use Spatie\LaravelData\Normalizers\ArrayNormalizer;
use Spatie\LaravelData\Normalizers\JsonNormalizer;
use Spatie\LaravelData\Normalizers\ModelNormalizer;
use Spatie\LaravelData\Normalizers\ObjectNormalizer;
use Spatie\LaravelData\Support\DataConfig;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->app->when(DataConfig::class)
            ->needs('$config')
            ->give([]);
    }

    protected function getPackageProviders($app): array
    {
        return [
          PaymentSDKServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('pay-config.paystack.ghana.base_url', 'https://api.paystack.co');
        $app['config']->set('pay-config.paystack.ghana.secret_key', 'sk_test_ffa6d1d1845199837744ac56658ad8313c8ec718');
        $app['config']->set('pay-config.paystack.ghana.jetstream_charge', 0.00);

        
        $app['config']->set('pay-config.paystack.nigeria.base_url', 'https://api.paystack.co');
        $app['config']->set('pay-config.paystack.nigeria.secret_key', 'sk_test_efb5c7082a15bce8c59c309f2ca1571a0d9e8283');
        $app['config']->set('pay-config.paystack.nigeria.jetstream_charge', 0.00);


        $app['config']->set('data.normalizers', [
            ModelNormalizer::class,
            ArrayableNormalizer::class,
            ObjectNormalizer::class,
            ArrayNormalizer::class,
            JsonNormalizer::class,
        ]);
    }
}