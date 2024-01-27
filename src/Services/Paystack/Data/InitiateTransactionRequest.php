<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Data;

use Spatie\LaravelData\Data;

class InitiateTransactionRequest extends Data
{
  public function __construct(
    public float $amount,
    public string $email,
    public string $reference,
    public ?string $metadata,
    public ?string $subaccount 
  ) {
  }
}
