<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Bills
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List bills with optional filtering.
     */
    public function listBills($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "bills?$queryParams");
    }

    /**
     * Fetch a specific bill by its ID.
     */
    public function fetchBill($billId)
    {
        return $this->ramp->sendRequest('GET', "bills/$billId");
    }
}