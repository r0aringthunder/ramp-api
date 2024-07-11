# [Ramp API for PHP](https://docs.ramp.com) [![Software License][ico-license]](LICENSE.md) ![GitHub last commit][ico-last-commit]


## Available services
 - [Accounting](https://docs.ramp.com/developer-api/v1/reference/rest/accounting) `Ex: $ramp->accounting->...`
 - [Accounting Connections](https://docs.ramp.com/developer-api/v1/reference/rest/accounting-connections) `Ex: $ramp->accountingconnections->...`
 - [Bills](https://docs.ramp.com/developer-api/v1/reference/rest/bills) `Ex: $ramp->bills->...`
 - [Business](https://docs.ramp.com/developer-api/v1/reference/rest/business) `Ex: $ramp->business->...`
 - **Card Programs - This is not implemented and instead you should use [Spend Programs](https://docs.ramp.com/developer-api/v1/reference/rest/spend-programs)**
 - [Cards](https://docs.ramp.com/developer-api/v1/reference/rest/cards) `Ex: $ramp->cards->...`
 - [Cash Backs](https://docs.ramp.com/developer-api/v1/reference/rest/cashbacks) `Ex: $ramp->cashbacks->...`
 - [Departments](https://docs.ramp.com/developer-api/v1/reference/rest/departments) `Ex: $ramp->departments->...`
 - [Entities](https://docs.ramp.com/developer-api/v1/reference/rest/entities) `Ex: $ramp->entities->...`
 - [Leads](https://docs.ramp.com/developer-api/v1/reference/rest/leads) `Ex: $ramp->leads->...`
 - [Ledger Accounts](https://docs.ramp.com/developer-api/v1/reference/rest/ledger-accounts) `Ex: $ramp->ledgeraccounts->...`
 - [Limits](https://docs.ramp.com/developer-api/v1/reference/rest/ledger-accounts) `Ex: $ramp->limits->...`
 - [Locations](https://docs.ramp.com/developer-api/v1/reference/rest/locations) `Ex: $ramp->locations->...`
 - [Memos](https://docs.ramp.com/developer-api/v1/reference/rest/locations) `Ex: $ramp->memos->...`
 - [Merchants](https://docs.ramp.com/developer-api/v1/reference/rest/merchants) `Ex: $ramp->merchants->...`
 - [Receipt Integrations](https://docs.ramp.com/developer-api/v1/reference/rest/receipt-integrations) `Ex: $ramp->receiptintegrations->...`
 - [Receipts](https://docs.ramp.com/developer-api/v1/reference/rest/receipts) `Ex: $ramp->receipts->...`
 - [Reimbursements](https://docs.ramp.com/developer-api/v1/reference/rest/reimbursements) `Ex: $ramp->reimbursements->...`
 - [Spend Programs](https://docs.ramp.com/developer-api/v1/reference/rest/spend-programs) `Ex: $ramp->spendprograms->...`
 - [Statements](https://docs.ramp.com/developer-api/v1/reference/rest/statements) `Ex: $ramp->statements->...`
 - [Transactions](https://docs.ramp.com/developer-api/v1/reference/rest/transactions) `Ex: $ramp->transactions->...`
 - [Transfers](https://docs.ramp.com/developer-api/v1/reference/rest/transfers) `Ex: $ramp->transfers->...`
 - [Users](https://docs.ramp.com/developer-api/v1/reference/rest/users) `Ex: $ramp->users->...`
 - [Vendors](https://docs.ramp.com/developer-api/v1/reference/rest/vendors) `Ex: $ramp->vendors->...`

## Publishing the ramp config
#### Command
```bash
php artisan vendor:publish --tag=rampapi-config
```
#### published `config/ramp.php`
```php
<?php

return [
    'client_id' => env('RAMP_CLIENT_ID', 'your_client_id'),
    'client_secret' => env('RAMP_CLIENT_SECRET', 'your_client_secret'),
    'prod_ready' => env('PROD_READY', false),
    'scopes' => env('RAMP_SCOPES', 'accounting:read accounting:write bills:read business:read cards:read cards:write cashbacks:read departments:read departments:write entities:read leads:read leads:write limits:read limits:write locations:read locations:write memos:read merchants:read receipt_integrations:read receipt_integrations:write receipts:read reimbursements:read spend_programs:read spend_programs:write statements:read transactions:read transfers:read users:read users:write'),
];
```

## Examples
#### Fetching a list of users
```php
use R0aringthunder\RampApi\Ramp;

public function rampUsers()
{
  $ramp = new Ramp();
  $users = $ramp->users->listUsers();
  return response()->json($users);
}
```

#### Fetching all cards
```php
use R0aringthunder\RampApi\Ramp;

public function fetchCards()
{
    $ramp = new Ramp();
    $cards = $ramp->cards->listCards();
    return response()->json($cards['data']);
}
```

#### Fetching a single card
```php
use R0aringthunder\RampApi\Ramp;

public function fetchCard()
{
  $ramp = new Ramp();
  $card = $ramp->cards->fetchCard('[CARD ID]');
  return response()->json($card);
}
```

> [!IMPORTANT]  
> At the time of implementation the API and Ramp dashbaord take approximately 5 minutes to sync but the API reacts immediately to changes

> [!IMPORTANT]  
> The only file types accepted by Ramp are `png, webp, heif, pdf, heic, jpg, jpeg`
#### Uploading a receipt to a transaction
```php
use R0aringthunder\RampApi\Ramp;
use Illuminate\Http\Request;

public function uploadReceipt(Request $request)
{
  $ramp = new Ramp();

  $file = $request->file('receipts');
  $path = $file->getRealPath();

  return $ramp->receipts->upload(
      [
          'user_id' => $request->input('ramp_user_id'),
          'transaction_id' => $request->input('ramp_transaction_id'),
      ],
      $path
  );
}
```

> [!TIP]
> On `$path` you can use an uploaded file or a link to a file (Ex. an S3 link)

***More exmaples coming...***

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-last-commit]: https://img.shields.io/github/last-commit/r0aringthunder/ramp-api?style=flat-square
