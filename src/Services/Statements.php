<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Statements
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List statements with optional filters.
     */
    public function list($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "statements?$queryParams");
    }

    /**
     * Fetch a specific statement by its ID.
     */
    public function fetch($statementId)
    {
        return $this->ramp->sendRequest('GET', "statements/$statementId");
    }
}
