<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Impl;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\CreateSubAccountResponse;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\CreateSubAccountRequest;
use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackSubAccountService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;


class PaystackSubAccountServiceImpl implements PaystackSubAccountService {

  public function createSubAccount (CreateSubAccountRequest $request, OptionArgs $args): null | CreateSubAccountResponse
  {
    try {
      $countryConfig = config('config.paystack')[$args->country];
      $charges = $countryConfig['charge'];
      $response = Http::payment($args->country)->post('/subaccount', [
        'business_name' => $request->business_name,
        'settlement_bank' => $request->settlement_bank,
        'account_number' => $request->account_number,
        'percentage_charge' => $charges,
        'description' => $request->description,
        'primary_contact_email' => $request->primary_contact_email,
        'primary_contact_name' => $request->primary_contact_name,
        'primary_contact_phone' => $request->primary_contact_phone,
        'metadata' => $request->metadata
      ]);
      $responseArray = $response->json();
      if(!$responseArray["status"]) {
        throw new InvalidArgumentException("Error Processing Request:".$responseArray["message"], 400);
      }
      return CreateSubAccountResponse::from($responseArray);
    } catch (RequestException $e) {
      Log::error("Initialize transaction failed:". $e->getMessage());
      return null;
    }
  }
}