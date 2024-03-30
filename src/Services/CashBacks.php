<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class CashBacks
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List cashback payments with optional filtering.
     */
    public function listCashbacks($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "cashbacks?$queryParams");
    }

    /**
     * Fetch a specific cashback payment by its ID.
     */
    public function fetchCashback($cashbackId)
    {
        return $this->ramp->sendRequest('GET', "cashbacks/$cashbackId");
    }
}
