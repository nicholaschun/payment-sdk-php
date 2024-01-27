<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Interface;

use Nicholaschun\PaymentSDK\Services\Paystack\Data\CreateSubAccountRequest;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\CreateSubAccountResponse;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;

interface PaystackSubAccountService 
{
  public function createSubAccount (CreateSubAccountRequest $request, OptionArgs $args): CreateSubAccountResponse | null;
}