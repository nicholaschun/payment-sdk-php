<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Data;

use Spatie\LaravelData\Data;


class InitiateTransactionData extends Data
{
  public function __construct(
    public ?string $authorization_url,
    public ?string $access_code,
    public ?string $reference
  ) {
  }
}

class InitiateTransactionResponse extends Data
{
  public function __construct(
    public bool $status,
    public string $message,
    public ?InitiateTransactionData $data
  ) {
  }
}
