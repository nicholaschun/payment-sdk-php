<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Data;

use Spatie\LaravelData\Data;

class CreateSubAccountRequest extends Data
{
  public function __construct(
    public string $business_name,
    public string $settlement_bank,
    public string $account_number,
    public ?string $description,
    public ?string $primary_contact_email,
    public ?string $primary_contact_name,
    public ?string $primary_contact_phone,
    public ?string $metadata
  ) {
  }
}
