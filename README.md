# [Ramp API for PHP](https://docs.ramp.com) [![Software License][ico-license]](LICENSE.md) ![GitHub last commit][ico-last-commit]


## Available services
 - [Accounting](https://docs.ramp.com/developer-api/v1/reference/rest/accounting)
 - [Accounting Connections](https://docs.ramp.com/developer-api/v1/reference/rest/accounting-connections)
 - [Bills](https://docs.ramp.com/developer-api/v1/reference/rest/bills)
 - [Business](https://docs.ramp.com/developer-api/v1/reference/rest/business)
 - **Card Programs - This is not implemented and instead you should use [Spend Programs](https://docs.ramp.com/developer-api/v1/reference/rest/spend-programs)**
 - [Cards](https://docs.ramp.com/developer-api/v1/reference/rest/cards)
 - [Cash Backs](https://docs.ramp.com/developer-api/v1/reference/rest/cashbacks)
 - [Departments](https://docs.ramp.com/developer-api/v1/reference/rest/departments)
 - [Entities](https://docs.ramp.com/developer-api/v1/reference/rest/entities)
 - [Leads](https://docs.ramp.com/developer-api/v1/reference/rest/leads)
 - [Ledger Accounts](https://docs.ramp.com/developer-api/v1/reference/rest/ledger-accounts)
 - [Limits](https://docs.ramp.com/developer-api/v1/reference/rest/ledger-accounts)
 - [Locations](https://docs.ramp.com/developer-api/v1/reference/rest/locations)
 - [Memos](https://docs.ramp.com/developer-api/v1/reference/rest/locations)
 - [Merchants](https://docs.ramp.com/developer-api/v1/reference/rest/merchants)
 - [Receipt Integrations](https://docs.ramp.com/developer-api/v1/reference/rest/receipt-integrations)
 - [Receipts](https://docs.ramp.com/developer-api/v1/reference/rest/receipts)
 - [Reimbursements](https://docs.ramp.com/developer-api/v1/reference/rest/reimbursements)
 - [Spend Programs](https://docs.ramp.com/developer-api/v1/reference/rest/spend-programs)
 - [Statements](https://docs.ramp.com/developer-api/v1/reference/rest/statements)
 - [Transactions](https://docs.ramp.com/developer-api/v1/reference/rest/transactions)
 - [Transfers](https://docs.ramp.com/developer-api/v1/reference/rest/transfers)
 - [Users](https://docs.ramp.com/developer-api/v1/reference/rest/users)
 - [Vendors](https://docs.ramp.com/developer-api/v1/reference/rest/vendors)

## Examples
### Fetching a list of users
```php
use R0aringthunder\RampApi\Ramp;

public function rampUsers()
{
  $ramp = new Ramp();
  $users = $ramp->users->listUsers();
  return response()->json($users);
}
```

### Fetching all cards
```php
public function fetchCards()
{
    $ramp = new Ramp();
    $cards = $ramp->cards->listCards();
    return response()->json($cards['data']);
}
```

### Fetching a single card
```php
public function fetchCard()
{
  $ramp = new Ramp();
  $card = $ramp->cards->fetchCard('[CARD ID]');
  return response()->json($card);
}
```

***More exmaples coming...***

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-last-commit]: https://img.shields.io/github/last-commit/r0aringthunder/ramp-api?style=flat-square
