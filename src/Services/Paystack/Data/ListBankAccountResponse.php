<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class BankAccountData extends Data {
  public function __construct (
    public ?string $id,
    public ?string $name,
    public ?string $slug,
    public ?string $code,
    public ?string $longcode,
    public ?string $gateway,
    public ?string $pay_with_bank,
    public ?bool   $active,
    public ?string $country,
    public ?string $currency,
    public ?string $type,
    public ?string $is_deleted,
    public ?string $createdAt,
    public ?string $updatedAt
  )
  {}
}

class BankAccountMeta extends Data {
  public function __construct(
    public ?string $next,
    public ?string $previous,
    public ?int $perPage
  ){}
}

class ListBankAccountResponse extends Data {
  public function __construct (
    public bool $status,
    public string $message,
    #[DataCollectionOf(BankAccountData::class)]
    public ?DataCollection $data,
    public ?BankAccountMeta $meta
  )
  {}
}