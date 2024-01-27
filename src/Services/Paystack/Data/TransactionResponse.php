<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Data;

use Spatie\LaravelData\Data;


class CustomerData extends Data {
  public function __construct(
    public ?int $id,
    public ?string $first_name,
    public ?string $last_name,
    public ?string $email,
    public ?string $customer_code,
    public ?string $phone,
    public ?string $metadata,
    public ?string $risk_action,
    public ?string $international_format_phone
  )
  {}
}

class TransactionSubAccountData extends Data {
  public function __construct(
    public ?int $id,
    public ?string $subaccount_code,
    public ?string $business_name,
    public ?string $description,
    public ?string $primary_contact_name,
    public ?string $primary_contact_email,
    public ?string $primary_contact_phone,
    public ?string $metadata,
    public ?float $percentage_charge,
    public ?string $settlement_bank,
    public ?string $bank_id,
    public ?string $account_number,
    public ?string $currency,
    public ?bool $active

  ) {}
}
class TransactionData extends Data
{
  public function __construct(
    public ?int $id,
    public ?string $domain,
    public ?string $status,
    public ?string  $reference,
    public ?int $amount,
    public ?string $message,
    public ?string $gateway_response,
    public ?string $paid_at,
    public ?string $created_at,
    public ?string $channel,
    public ?string $currency,
    public ?string $ip_address,
    public ?string $metadata,
    public ?float $fees,
    public ?float $fees_split,
    public ?CustomerData $customer,
    public ?TransactionSubAccountData $subaccount
  ) {
  }
}

class TransactionResponse extends Data
{
  public function __construct(
    public bool $status,
    public string $message,
    public ?TransactionData $data
  ) {
  }
}
