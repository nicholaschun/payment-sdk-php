<?php
namespace Nicholaschun\PaymentSDK\Tests\Feature;

use Nicholaschun\PaymentSDK\Services\Paystack\Data\InitiateTransactionRequest;
use Nicholaschun\PaymentSDK\Services\Paystack\Impl\PaystackTransactionServiceImpl;
use Nicholaschun\PaymentSDK\Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;



class PaystackTransactionServiceTest extends TestCase
{

  public function test_that_user_can_initiate_transaction()
  {
    Http::preventStrayRequests();
    $paystackTransactionServiceImp = new PaystackTransactionServiceImpl();

    $payload = InitiateTransactionRequest::from([
        "amount" => 90 * 100,
        "email" => "test@gmail.com",
        "subaccount" => "ACCT_ddwhgxfii9b8b9c",
        "reference" =>  uniqid()
    ]);

    $json = file_get_contents('src/Services/Paystack/Data/InitiateTransaction.json');
    $response = json_decode($json,true);

    $base_url = config('pay-config.paystack.ghana.base_url');
    Http::fake([
      $base_url . '/transaction/initialize'
      => Http::response($response)
    ]);
   
    
    $result = $paystackTransactionServiceImp->initializeTransaction($payload, OptionArgs::from([ 
      'country' => 'ghana'
    ]));
    $this->assertEquals($result->toArray(), $response);
  }
  public function test_that_user_can_verify_transaction()
  {
    Http::preventStrayRequests();
    $paystackTransactionServiceImp = new PaystackTransactionServiceImpl();
    $reference = 's7azq32g7d';
    
    $json = file_get_contents('src/Services/Paystack/Data/VerifyTransaction.json');
    $response = json_decode($json,true);

    $base_url = config('pay-config.paystack.ghana.base_url');
    Http::fake([
      $base_url . '/transactions/verify/'.$reference
      => Http::response($response)
    ]);
    $result = $paystackTransactionServiceImp->verifyTransaction($reference, OptionArgs::from([ 
      'country' => 'ghana'
    ]));
    $this->assertEquals($result->toArray(), $response);
  }
  
  public function test_that_user_can_get_transaction()
  {
    Http::preventStrayRequests();
    $paystackTransactionServiceImp = new PaystackTransactionServiceImpl();
    $transactionId = '3487979145';
    

    $json = file_get_contents('src/Services/Paystack/Data/VerifyTransaction.json');
    $response = json_decode($json,true);

    $base_url = config('pay-config.paystack.ghana.base_url');
    Http::fake([
      $base_url . '/transaction/'.$transactionId
      => Http::response($response)
    ]);

    $result = $paystackTransactionServiceImp->getTransaction($transactionId, OptionArgs::from([ 
      'country' => 'ghana'
    ]));
    $this->assertEquals($result->toArray(), $response);
  }
  
}
