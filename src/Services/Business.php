<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

/**
 * Provides methods to interact with business-related endpoints of the Ramp API.
 */
class Business
{
    /**
     * @var Ramp The Ramp service instance to handle API requests.
     */
    protected $ramp;

    /**
     * Initializes a new instance of the Business service.
     *
     * @param Ramp $ramp The Ramp service instance.
     */
    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * Fetches company information from the Ramp API.
     *
     * @return array The response from the Ramp API.
     */
    public function fetch(): array
    {
        return $this->ramp->sendRequest(method: "GET", endpoint: "business");
    }

    /**
     * Fetches the company's balance information from the Ramp API.
     *
     * @return array The response from the Ramp API.
     */
    public function balance(): array
    {
        return $this->ramp->sendRequest(method: "GET", endpoint: "business/balance");
    }
}
