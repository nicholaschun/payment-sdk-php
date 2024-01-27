<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Impl;

use Nicholaschun\PaymentSDK\Services\Paystack\Data\InitiateTransactionRequest;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\InitiateTransactionResponse;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\TransactionResponse;
use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackTransactionService;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;


class PaystackTransactionServiceImpl implements PaystackTransactionService
{


  public function initializeTransaction(InitiateTransactionRequest $request, OptionArgs $args): InitiateTransactionResponse | null
  {
    try {
      $response = Http::payment($args->country)->post('/transaction/initialize', [
        "email" => $request->email,
        "amount" => $request->amount * 100,
        "subaccount" => $request->subaccount,
        "reference" => $request->reference,
        "bearer" => "subaccount",
        "channels" => ["card", "bank", "ussd", "qr", "mobile_money", "bank_transfer", "eft"]
      ]);

      $responseArray = $response->json();
      if (!$responseArray["status"]) {
        throw new InvalidArgumentException("Error Processing Request:" . $responseArray["message"], 400);
      }      
      return InitiateTransactionResponse::from($responseArray);
    } catch (RequestException $e) {
      Log::error("Initialize transaction failed:" . $e->getMessage());
      return null;
    }
  }
  public function verifyTransaction(string $reference, OptionArgs $args): TransactionResponse | null
  {
    try {
      $response = Http::payment($args->country)->get('/transactions/verify/'.$reference);
      $responseArray = $response->json();
      if (!$responseArray["status"]) {
        throw new InvalidArgumentException("Error Processing Request:" . $responseArray["message"], 400);
      }
      return TransactionResponse::from($responseArray);
    } catch (RequestException $e) {
      Log::error("verify transaction failed:" . $e->getMessage());
      return null;
    }
  }
  public function getTransaction(string $transactionId, OptionArgs $args):TransactionResponse | null
  {
    try {
      $response = Http::payment($args->country)->get('/transaction/' . $transactionId);
      $responseArray = $response->json();
      if (!$responseArray["status"]) {
        throw new InvalidArgumentException("Error Processing Request:" . $responseArray["message"], 400);
      }
      return TransactionResponse::from($responseArray);
    } catch (RequestException $e) {
      Log::error("verify transaction failed:" . $e->getMessage());
      return null;
    }
  }
}