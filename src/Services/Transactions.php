<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Transactions extends Base
{
    /**
     * List transactions with optional filters.
     */
    public function list($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "transactions?$queryParams");
    }

    /**
     * Fetch a specific transaction by its ID.
     */
    public function fetch($transactionId)
    {
        return $this->ramp->sendRequest('GET', "transactions/$transactionId");
    }
}
