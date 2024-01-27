<?php
namespace Nicholaschun\PaymentSDK\Tests\Feature;
use Illuminate\Support\Facades\Http;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\ListBankAccountRequest;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;
use Nicholaschun\PaymentSDK\Services\Paystack\Impl\PaystackBankServiceImpl;
use Nicholaschun\PaymentSDK\Tests\TestCase;

class PaystackBankServiceTest extends TestCase {

  public function test_that_user_can_get_bank_details() 
  {
     Http::preventStrayRequests();

    $paystackBankServiceImp = new PaystackBankServiceImpl();

    $payload = ListBankAccountRequest::from([
      'country' => 'ghana',
      'use_cursor' => true,
      'per_page' => 200
    ]);

    $json = file_get_contents('src/Services/Paystack/Data/ListBank.json');
    $response = json_decode($json,true);

    $base_url = config('pay-config.paystack.ghana.base_url');
    Http::fake([
      $base_url . '/bank/?country=ghana&use_cursor=1&perPage=200'
      => Http::response($response)
    ]);
   
    $result = $paystackBankServiceImp->listBank($payload, OptionArgs::from([ 
      'country' => $payload->country
    ]) );
    $this->assertEquals($result->toArray(), $response);
  }

}