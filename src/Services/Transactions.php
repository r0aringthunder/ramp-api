<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Setup\Base;

class Transactions extends Base
{
    /**
     * List transactions with optional filters.
     */
    public function list(array $filters = []): array
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "transactions?$filters"
        );
    }

    /**
     * Fetch a specific transaction by its ID.
     */
    public function fetch(array $id): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "transactions/$id"
        );
    }
}
