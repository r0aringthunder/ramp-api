<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Transactions
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List transactions with optional filters.
     */
    public function listTransactions($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "transactions?$queryParams");
    }

    /**
     * Fetch a specific transaction by its ID.
     */
    public function fetchTransaction($transactionId)
    {
        return $this->ramp->sendRequest('GET', "transactions/$transactionId");
    }
}
