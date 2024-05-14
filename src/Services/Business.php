<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Setup\Base;

/**
 * Provides methods to interact with business-related endpoints of the Ramp API.
 */
class Business extends Base
{
    /**
     * Fetches company information from the Ramp API.
     *
     * @return array The response from the Ramp API.
     */
    public function fetch(): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "business"
        );
    }

    /**
     * Fetches the company's balance information from the Ramp API.
     *
     * @return array The response from the Ramp API.
     */
    public function balance(): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "business/balance"
        );
    }
}
