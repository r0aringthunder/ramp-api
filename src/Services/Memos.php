<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Memos extends Base
{
    /**
     * List memos with optional filters.
     */
    public function list($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "memos?$queryParams");
    }

    /**
     * Fetch a specific transaction memo by its ID.
     */
    public function fetch($transactionId)
    {
        return $this->ramp->sendRequest('GET', "memos/$transactionId");
    }
}
