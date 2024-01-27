<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Interface;

use Nicholaschun\PaymentSDK\Services\Paystack\Data\InitiateTransactionRequest;

use Nicholaschun\PaymentSDK\Services\Paystack\Data\InitiateTransactionResponse;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\TransactionResponse;

interface PaystackTransactionService 
{
  public function initializeTransaction (InitiateTransactionRequest $request, OptionArgs $args): InitiateTransactionResponse | null;
  public function verifyTransaction (string $reference, OptionArgs $args): TransactionResponse | null;
  public function getTransaction (string $transactionId, OptionArgs $args): TransactionResponse | null;
}