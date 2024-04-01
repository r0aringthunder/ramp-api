<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Receipts
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List receipts with optional filters.
     */
    public function list($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "receipts?$queryParams");
    }

    /**
     * Fetch a specific receipt by its ID.
     */
    public function fetch($receiptId)
    {
        return $this->ramp->sendRequest('GET', "receipts/$receiptId");
    }
}
