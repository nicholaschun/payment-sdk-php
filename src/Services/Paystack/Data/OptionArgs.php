<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Data;

use Spatie\LaravelData\Data;

class OptionArgs extends Data {
  public function __construct (
    public string $country
  )
  {}
}