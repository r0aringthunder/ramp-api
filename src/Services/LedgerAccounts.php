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
    public function list(array $filters = [])
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "accounting/accounts?$filters"
        );
    }

    /**
     * Upload general ledger accounts.
     */
    public function upload(array $data)
    {
        $data = json_encode(['gl_accounts' => $data]);
        return $this->ramp->sendRequest(
            method: "POST",
            endpoint: "accounting/accounts",
            data: "$data");
    }

    /**
     * Fetch a specific general ledger account by its ID.
     */
    public function fetch($id)
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "accounting/accounts/$id"
        );
    }

    /**
     * Update a general ledger account.
     */
    public function update($id, $data)
    {
        $data = json_encode($data);
        return $this->ramp->sendRequest(
            method: "PATCH",
            endpoint: "accounting/accounts/$id",
            data: "$data"
        );
    }

    /**
     * Delete a general ledger account.
     */
    public function delete($id)
    {
        return $this->ramp->sendRequest(
            method: "DELETE",
            endpoint: "accounting/accounts/$id"
        );
    }
}
