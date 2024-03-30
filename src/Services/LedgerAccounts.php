<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class LedgerAccounts
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List general ledger accounts with optional filters.
     */
    public function listAccounts($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "accounting/accounts?$queryParams");
    }

    /**
     * Upload general ledger accounts.
     */
    public function uploadAccounts($glAccounts)
    {
        $data = ['gl_accounts' => $glAccounts];
        return $this->ramp->sendRequest('POST', 'accounting/accounts', $data);
    }

    /**
     * Fetch a specific general ledger account by its ID.
     */
    public function fetchAccount($accountId)
    {
        return $this->ramp->sendRequest('GET', "accounting/accounts/$accountId");
    }

    /**
     * Update a general ledger account.
     */
    public function updateAccount($accountId, $accountData)
    {
        return $this->ramp->sendRequest('PATCH', "accounting/accounts/$accountId", $accountData);
    }

    /**
     * Delete a general ledger account.
     */
    public function deleteAccount($accountId)
    {
        return $this->ramp->sendRequest('DELETE', "accounting/accounts/$accountId");
    }
}
