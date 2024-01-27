<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Data;

use Spatie\LaravelData\Data;

class ListBankAccountRequest extends Data
{
  public function __construct(
    public string $country,
    public ?bool $use_cursor,
    public ?int $per_page,
    public ?bool $pay_with_bank_transfer,
    public ?bool $pay_with_bank, 
    public ?string $next,
    public ?string $previous,
    public ?string $gateway,
    public ?string $type,
    public ?string $currency
  ) {
  }
}
