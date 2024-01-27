<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Data;

use Spatie\LaravelData\Data;

class SubAccountData extends Data 
{
  public function __construct(
    public ?int $integration,
    public ?string $domain,
    public ?string $subaccount_code,
    public ?string $business_name,
    public ?string $description,
    public ?string $primary_contact_name,
    public ?string $primary_contact_email,
    public ?string $primary_contact_phone,
    public ?string  $metadata,
    public ?float $percentage_charge,
    public ?bool $is_verified,
    public ?string $settlement_bank,
    public ?string $account_number,
    public ?string $settlement_schedule,
    public ?bool $active,
    public ?bool $migrate,
    public ?int $id,
    public ?string $createdAt,
    public ?string $updatedAt
  ){}
  
}
class CreateSubAccountResponse extends Data
{
  public function __construct(
    public bool $status,
    public string $message,
    public ?SubAccountData $data
  ) {
  }
}
