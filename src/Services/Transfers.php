<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Transfers extends Base
{
    /**
     * List transfer payments with optional filters.
     */
    public function list($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "transfers?$queryParams");
    }

    /**
     * Fetch a specific transfer payment by its ID.
     */
    public function fetch($transferId)
    {
        return $this->ramp->sendRequest('GET', "transfers/$transferId");
    }
}
