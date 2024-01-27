<?php
namespace Nicholaschun\PaymentSDK\Tests\Feature;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\CreateSubAccountRequest;
use Nicholaschun\PaymentSDK\Services\Paystack\Impl\PaystackSubAccountServiceImpl;
use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;
use Nicholaschun\PaymentSDK\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class PaystackSubAccountServiceTest extends TestCase {

  public function test_that_user_can_create_subaccount() 
  {
    Http::preventStrayRequests();
    $paystackSubAccountServiceImp = new PaystackSubAccountServiceImpl();

    $payload = CreateSubAccountRequest::from([
      'business_name' => 'Nick Freight',
      'settlement_bank' => '190100',
      'account_number' => '9040008381032',
      'percentage_charge' => 10.00,
      'description' => 'Testing subaccounts',
      'primary_contact_email' => 'test@gmail.com',
      'primary_contact_name' => 'Test Account',
      'primary_contact_phone' => '+233543343891',
      'metadata' => 'stringify payload'
    ]);

    $json = file_get_contents('src/Services/Paystack/Data/CreateSubAccount.json');
    $response = json_decode($json,true);

    $base_url = config('pay-config.paystack.ghana.base_url');
    Http::fake([
      $base_url . '/subaccount'
      => Http::response($response)
    ]);

    $result = $paystackSubAccountServiceImp->createSubAccount($payload, OptionArgs::from([ 
      'country' => 'ghana'
    ]));
    $this->assertEquals($result->toArray(), $response);
  }

}