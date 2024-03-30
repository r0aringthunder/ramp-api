<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Business
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * Fetch the company information.
     */
    public function fetchCompanyInformation()
    {
        return $this->ramp->sendRequest('GET', 'business');
    }

    /**
     * Fetch the company balance information.
     */
    public function fetchCompanyBalanceInformation()
    {
        return $this->ramp->sendRequest('GET', 'business/balance');
    }
}
