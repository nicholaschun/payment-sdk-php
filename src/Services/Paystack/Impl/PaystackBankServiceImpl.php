<?php
namespace Nicholaschun\PaymentSDK\Services\Paystack\Impl;

use Nicholaschun\PaymentSDK\Services\Paystack\Data\ListBankAccountRequest;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\ListBankAccountResponse;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;
use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackBankService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;


class PaystackBankServiceImpl implements PaystackBankService {
  public function listBank(ListBankAccountRequest $request, OptionArgs $args): ListBankAccountResponse | null
  {
    $country = $request->country;
    $use_cursor = $request->use_cursor ? '&use_cursor='. $request->use_cursor : '';
    $per_page = $request->per_page ? '&perPage='. $request->per_page : '';
    $pay_with_bank_transfer = $request->pay_with_bank_transfer ? '&pay_with_bank_transfer='. $request->pay_with_bank_transfer : '';
    $pay_with_bank = $request->pay_with_bank ? '&pay_with_bank='. $request->pay_with_bank : '';
    $next = $request->next ? '&pay_with_bank='. $request->next : '';
    $previous = $request->previous ? '&previous='. $request->previous : '';
    $gateway = $request->gateway ? '&gateway='. $request->gateway : '';
    $type = $request->type ? '&type='. $request->type : '';
    $currency = $request->currency ? '&currency='. $request->currency : '';

    $url = '/bank/?country='.$country.$use_cursor.$per_page.$pay_with_bank_transfer.$pay_with_bank.$next.$previous.$gateway.$type.$currency;
    try {
      $response = Http::payment($args->country)->get($url);
      $responseArray = $response->json();
      if(!$responseArray["status"]) {
        throw new InvalidArgumentException("Error Processing Request:".$responseArray["message"], 400);
      }
      return ListBankAccountResponse::from($responseArray);
    } catch (RequestException $e) {
      Log::error("verify transaction failed:". $e->getMessage());
      return null;
    }
  }
}