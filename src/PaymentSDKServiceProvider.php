<?php
namespace Nicholaschun\PaymentSDK;

use Illuminate\Support\ServiceProvider;
use Nicholaschun\PaymentSDK\Console\InstallCommand;
use Illuminate\Support\Facades\Http;
use Nicholaschun\PaymentSDK\Services\Paystack\Impl\PaystackBankServiceImpl;
use Nicholaschun\PaymentSDK\Services\Paystack\Impl\PaystackSubAccountServiceImpl;
use Nicholaschun\PaymentSDK\Services\Paystack\Impl\PaystackTransactionServiceImpl;
use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackBankService;
use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackSubAccountService;
use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackTransactionService;

class PaymentSDKServiceProvider extends ServiceProvider
{


  public function register():void
  {
    // Register service providers here
    $this->app->bind(PaystackSubAccountService::class, PaystackSubAccountServiceImpl::class);
    $this->app->bind(PaystackTransactionService::class, PaystackTransactionServiceImpl::class);
    $this->app->bind(PaystackBankService::class, PaystackBankServiceImpl::class);
  }

  public function boot():void
  {
    $this->publishes([
        __DIR__ . '/../config/pay-config.php' => config_path('pay-config.php')
    ], 'payment-config');

    $this->commands([
      InstallCommand::class
  ]);

  Http::macro('payment', function ($country) {
    $configObj = config('pay-config.paystack');
    $countryConfig = $configObj[$country];
    return Http::withHeaders([
      'Accept' => 'application/json',
      'Authorization' => 'Bearer '.$countryConfig['secret_key'],
      "Cache-Control: no-cache"
    ])->baseUrl($countryConfig['base_url']);
  });
  }
}