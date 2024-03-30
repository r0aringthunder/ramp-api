<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Transfers
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List transfer payments with optional filters.
     */
    public function listTransfers($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "transfers?$queryParams");
    }

    /**
     * Fetch a specific transfer payment by its ID.
     */
    public function fetchTransfer($transferId)
    {
        return $this->ramp->sendRequest('GET', "transfers/$transferId");
    }
}
