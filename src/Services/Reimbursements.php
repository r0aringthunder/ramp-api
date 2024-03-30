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
    public function listReimbursements($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "reimbursements?$queryParams");
    }

    /**
     * Fetch a specific reimbursement by its ID.
     */
    public function fetchReimbursement($reimbursementId)
    {
        return $this->ramp->sendRequest('GET', "reimbursements/$reimbursementId");
    }
}
