# <div align="center">Payment SDK PHP</div>
<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![GitHub Issues](https://img.shields.io/github/issues/nicholaschun/The-Documentation-Compendium.svg)](https://github.com/nicholaschun/payment-sdk-php/issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/nicholaschun/The-Documentation-Compendium.svg)](https://github.com/nicholaschun/payment-sdk-php/pulls)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](/LICENSE)

</div>

---

<p align="center"> Paystack Payment Integration SDK package for laravel applications
    <br> 
</p>

## 📝 Table of Contents

- [About](#about)
- [Getting Started](#getting_started)
- [Components](#components)
- [Usage](#usage)
- [Built Using](#built_using)
- [Authors](#authors)

## 🧐 About <a name = "about"></a>
This Payment is a Laravel SDK package with services for easily interacting with the Paystack and Strip Payment Apis.

## 🏁 Getting Started <a name = "getting_started"></a>

### Prerequisites
Before setting up this project on your local machine, you need the following requirements:

1. PHP v8.2.4
2. Composer v2.5.5

NB: versions may vary

### Set Up
To set up the project:

- Clone the repository using the command:
    ```bash
    git clone https://github.com/nicholaschun/payment-sdk-php.git
    ```

- Install dependencies using the command:
    ```bash
    composer install
    ```

- And, run tests using the command:
    ```bash
    composer test
    ```
- Provide correct secret keys for accounts for each country in pay-config config
```
'paystack' => [
    'ghana' => [
      'base_url' => env('PAYSTACK_BASE_URL', 'https://api.paystack.co'),
      'secret_key' => env('PAYSTACK_SECRET_KEY_GH', 'sk_test_xxxxxxxx'),
      'charge' => env('PAYSTACK_CHARGE_GH', 0.00)
    ],
    'nigeria' => [
      'base_url' => env('PAYSTACK_BASE_URL', 'https://api.paystack.co'),
      'secret_key' => env('PAYSTACK_SECRET_KEY_NG', 'sk_test_xxxxxxxx'),
      'charge' => env('PAYSTACK_CHARGE_NG', 0.00)

    ],
  ]
```


## 🧰 Components <a name = "components"></a>
This package currently  consumes the Paystack Payment Apis APIs with the following services:
1. Create A Sub Account
2. Initialize a transaction with subaccount
3. Verify Transaction
4. Get Transaction

#### Creating a Sub Account
Subaccounts allows you to split payment into multiple bank accounts.
Read more about subaccounts here https://paystack.com/docs/api/subaccount/

###### Creating a Sub Account Sample Usage
```php
   use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackSubAccountService;
   use Nicholaschun\PaymentSDK\Services\Paystack\Data\CreateSubAccountRequest;
   use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;

   class SampleClass
   {
       public function createSubAccount(PaystackSubAccountService $subAccountService)
       {
        $payload = CreateSubAccountRequest::from([
        'business_name' => 'Test Freight',
        'settlement_bank' => '190100',
        'account_number' => '9040008381032',
        'description' => 'Testing subaccounts',
        'primary_contact_email' => 'test@gmail.com',
        'primary_contact_name' => 'Test Account',
        'primary_contact_phone' => '+233543343891',
        'metadata' => 'sample metadata'
    ]);
           return $subAccountService->createSubAccount($payload, OptionArgs::from([ 
      'country' => 'ghana'
    ]) )
       }
   }
```

###### Creating a Sub Account Sample Response
```
{
  "status": true,
  "message": "Subaccount created",
  "data": {
    "integration": 100973,
    "domain": "test",
    "subaccount_code": "ACCT_4hl4xenwpjy5wb",
    "business_name": "Sunshine Studios",
    "description": null,
    "primary_contact_name": null,
    "primary_contact_email": null,
    "primary_contact_phone": null,
    "metadata": null,
    "percentage_charge": 18.2,
    "is_verified": false,
    "settlement_bank": "Access Bank",
    "account_number": "0193274682",
    "settlement_schedule": "AUTO",
    "active": true,
    "migrate": false,
    "id": 55,
    "createdAt": "2016-10-05T13:22:04.000Z",
    "updatedAt": "2016-10-21T02:19:47.000Z"
  }
}
```

#### Initiating a transaction with subaccount
Initialize a transaction from your backend
Read more about transactions here https://paystack.com/docs/api/transaction/#initialize

###### Initiating a transaction Sample Usage
```php
   use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackTransactionService;
   use Nicholaschun\PaymentSDK\Services\Paystack\Data\InitiateTransactionRequest;
   use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;

   class SampleClass
   {
       public function initiateTransaction(PaystackTransactionService $transactionService)
       {
        $payload = InitiateTransactionRequest::from([
        "amount" => 90,
        "email" => "test@gmail.com",
        "subaccount" => "ACCT_ddwhgxfii9b8b9c",
        "reference" =>  "1234567890"
    ]);
           return $transactionService->initializeTransaction($payload, OptionArgs::from([ 
      'country' => 'ghana'
    ]) )
       }
   }
```

###### Initiating a transaction Sample Response
```
{
  "status": true,
  "message": "Authorization URL created",
  "data": {
    "authorization_url": "https://checkout.paystack.com/0peioxfhpn",
    "access_code": "0peioxfhpn",
    "reference": "7PVGX8MEk85tgeEpVDtD"
  }
}
```

#### Verifying a transaction
Confirm the status of a transaction
Read more about transaction verifcation here https://paystack.com/docs/api/transaction/#verify

###### Verifying a transaction Sample Usage
```php
   use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackTransactionService;

   use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;

   class SampleClass
   {
       public function verifyTransaction(PaystackTransactionService $transactionService)
       {
        $reference = 's7azq32g7d';
           return $transactionService->verifyTransaction($reference, OptionArgs::from([ 
      'country' => 'ghana'
    ]) )
       }
   }
```

###### Verifying a transaction Sample Response
```
{
  "status": true,
  "message": "Verification successful",
  "data": {
    "id": 2009945086,
    "domain": "test",
    "status": "success",
    "reference": "rd0bz6z2wu",
    "amount": 20000,
    "message": null,
    "gateway_response": "Successful",
    "paid_at": "2022-08-09T14:21:32.000Z",
    "created_at": "2022-08-09T14:20:57.000Z",
    "channel": "card",
    "currency": "NGN",
    "ip_address": "100.64.11.35",
    "metadata": "",
    "fees": 100,
    "fees_split": null,
    "customer": {
      "id": 89929267,
      "first_name": null,
      "last_name": null,
      "email": "hello@email.com",
      "customer_code": "CUS_i5yosncbl8h2kvc",
      "phone": null,
      "metadata": null,
      "risk_action": "default",
      "international_format_phone": null
    },
    "subaccount": {
      "id" : 1030270,
      "subaccount_code" : "ACCT_6v323r07p3qm9yf",
      "business_name" : "Test Freight",
      "description" : "Test Freight",
      "primary_contact_name" : "Test Account",
      "primary_contact_email" : "test@gmail.com",
      "primary_contact_phone" : "+233543343891",
      "metadata" : "stringify payload",
      "percentage_charge" : 10,
      "settlement_bank" : "Stanbic Bank Ghana Limited",
      "bank_id" : 52,
      "account_number" : "7000008381000",
      "currency" : "GHS",
      "active" : true
    }
  }
}

```

#### Get a transaction
Get Details of a transaction
Read more about fetching a transaction here https://paystack.com/docs/api/transaction/#fetch

###### Get a transaction Sample Usage
```php
   use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackTransactionService;
   use 
   use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;

   class SampleClass
   {
       public function getTransaction(PaystackTransactionService $transactionService)
       {
        $transactionId = '3487979145';
           return $transactionService->getTransaction($transactionId, OptionArgs::from([ 
      'country' => 'ghana'
    ]) )
       }
   }
```

###### Get a transaction Sample Response
```
{
  "status": true,
  "message": "Verification successful",
  "data": {
    "id": 2009945086,
    "domain": "test",
    "status": "success",
    "reference": "rd0bz6z2wu",
    "amount": 20000,
    "message": null,
    "gateway_response": "Successful",
    "paid_at": "2022-08-09T14:21:32.000Z",
    "created_at": "2022-08-09T14:20:57.000Z",
    "channel": "card",
    "currency": "NGN",
    "ip_address": "100.64.11.35",
    "metadata": "",
    "fees": 100,
    "fees_split": null,
    "customer": {
      "id": 89929267,
      "first_name": null,
      "last_name": null,
      "email": "hello@email.com",
      "customer_code": "CUS_i5yosncbl8h2kvc",
      "phone": null,
      "metadata": null,
      "risk_action": "default",
      "international_format_phone": null
    },
    "subaccount": {
      "id" : 1030270,
      "subaccount_code" : "ACCT_6v323r07p3qm9yf",
      "business_name" : "Test Freight",
      "description" : "Test Freight",
      "primary_contact_name" : "Test Account",
      "primary_contact_email" : "test@gmail.com",
      "primary_contact_phone" : "+233543343891",
      "metadata" : "stringify payload",
      "percentage_charge" : 10,
      "settlement_bank" : "Stanbic Bank Ghana Limited",
      "bank_id" : 52,
      "account_number" : "7000008381000",
      "currency" : "GHS",
      "active" : true
    }
  }
}

```

#### Get a  list of Paystack Banks by country
Get a list of supported paystack banks by country
Current Supported Countries are 
1. ghana
2. nigeria
Read more about fetching a transaction here https://paystack.com/docs/api/transaction/#fetch

###### Get Bank List  Sample Usage
```php
   use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackBankService;
   use Nicholaschun\PaymentSDK\Services\Paystack\Data\ListBankAccountRequest;

   use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;

   class SampleClass
   {
       public function getBankList(PaystackBankService $bankService)
       {
        $payload = ListBankAccountRequest::from([
      'country' => 'ghana',
      'use_cursor' => true,
      'per_page' => 200
    ]);
           return $bankService->listBank($payload, OptionArgs::from([ 
      'country' => 'ghana' // ghana | nigeria
    ]) )
       }
   }
```

###### Get Bank List Sample Response
```
{
  "status": true,
  "message": "Banks retrieved",
  "data": [
    {
      "name": "Abbey Mortgage Bank",
      "slug": "abbey-mortgage-bank",
      "code": "801",
      "longcode": "",
      "gateway": null,
      "pay_with_bank": false,
      "active": true,
      "is_deleted": false,
      "country": "Nigeria",
      "currency": "NGN",
      "type": "nuban",
      "id": 174,
      "createdAt": "2020-12-07T16:19:09.000Z",
      "updatedAt": "2020-12-07T16:19:19.000Z"
    }
  ],
  "meta": {
    "next": "YmFuazoxNjk=",
    "previous": null,
    "perPage": 5
  }
}

```

## 🎈 Usage <a name="usage"></a>
This package is not available on Packagist. Hence, to use this package in your laravel project:
1. Add the following sections to your project's `composer.json` file:

    ```json
    {
      "require": {
        "nicholaschun/payment-sdk-php": "1.0.0"
      }
    }
    ```
    ```json
    {
      "repositories": [
        {
          "type": "vcs",
          "name": "nicholaschun/payment-sdk-php",
          "url": "https://github.com/nicholaschun/payment-sdk-php.git",
          "branch": "main"
        }
      ]
    }
    ```

2. The above section points to  a private repository, hence you would need to provide composer with a personal access
   token from GitHub to successfully pull the contents of the repo.
   For local development, it is recommended that you create
   a gitignored `auth.json` file with the following content, in the root of your project:

    ```json
    {
      "github-oauth": {
        "github.com": "token"
      }
    }
    ```

3. Then, proceed to run the following command to resolve the dependency:
    ```bash
    composer update
    ```

4. For remote access, you can set up an environment secret with name `COMPOSER_AUTH`, which will contain the JSON formatted
   content of the `auth.json` file:
    ```bash
    COMPOSER_AUTH='{"github-oauth":{"github.com":"token"}}'
    ```

5. After successfully adding this package to your project, you will need to publish the config file where you can
   set up your credentials for Sinay APIs access. The following command will allow you do that:
    ```bash
    php artisan payment-sdk:install
    ```

6. The config file `pay-config.php`, will be published to your config directory `./config`. Feel free to customize
   it to suit your needs.

7. To interact with any of the Payment SDK Services, inject any of the available service interfaces into your target
   method as shown below:
   ```php
   use Nicholaschun\PaymentSDK\Services\Paystack\Interface\PaystackTransactionService;
   use Nicholaschun\PaymentSDK\Services\Paystack\Data\InitiateTransactionRequest;
   use Nicholaschun\PaymentSDK\Services\Paystack\Data\OptionArgs;

   class SampleClass
   {
       public function initiateTransaction(PaystackTransactionService $transactionService)
       {
        $payload = InitiateTransactionRequest::from([
        "amount" => 90,
        "email" => "test@gmail.com",
        "subaccount" => "ACCT_ddwhgxfii9b8b9c",
        "reference" =>  "1234567890"
    ]);
           return $transactionService->initializeTransaction($payload, OptionArgs::from([ 
      'country' => 'ghana'
    ]) )
       }
   }
    ```

## ⛏️ Built Using <a name = "built_using"></a>
- [PHP](https://www.php.net/) - Language
- [Orchestral Testbench](https://github.com/orchestral/testbench) - Library
- [Laravel Data](https://spatie.be/docs/laravel-data/v3/introduction) Library

## ✍️ Authors <a name = "authors"></a>
- [@nicholaschun](https://github.com/nicholaschun)