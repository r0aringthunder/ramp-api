<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Reimbursements
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List reimbursements with optional filters.
     */
    public function list(array $filters = []): array
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "reimbursements?$filters"
        );
    }

    /**
     * Fetch a specific reimbursement by its ID.
     */
    public function fetch(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "reimbursements/$id"
        );
    }
}
