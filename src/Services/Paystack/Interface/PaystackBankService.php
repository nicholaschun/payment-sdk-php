<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Interface;

use Nicholaschun\PaymentSDK\Services\Paystack\Data\ListBankAccountRequest;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\ListBankAccountResponse;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;

interface PaystackBankService {
  public function listBank(ListBankAccountRequest $request, OptionArgs $args): ListBankAccountResponse | null ;
}