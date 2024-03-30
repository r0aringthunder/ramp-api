<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Memos
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List memos with optional filters.
     */
    public function listMemos($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "memos?$queryParams");
    }

    /**
     * Fetch a specific transaction memo by its ID.
     */
    public function fetchMemo($transactionId)
    {
        return $this->ramp->sendRequest('GET', "memos/$transactionId");
    }
}
