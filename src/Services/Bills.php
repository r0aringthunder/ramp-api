<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Setup\Base;

/**
 * Provides methods to interact with bills-related endpoints of the Ramp API.
 */
class Bills extends Base
{
    /**
     * Lists bills with optional filtering based on query parameters.
     *
     * @param array $filters An associative array of query parameters for filtering the bills. Possible keys include:
     *                       "entity_id", "payment_method", "payment_status", "sync_ready", "from_due_date", "to_due_date",
     *                       "from_issued_date", "to_issued_date", "start", "page_size".
     * @return array The response from the Ramp API.
     */
    public function list(array $filters = []): array
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "bills?$filters"
        );
    }

    /**
     * Fetches a specific bill by its unique identifier.
     *
     * @param string $billId The unique identifier of the bill to fetch.
     * @return array The response from the Ramp API.
     */
    public function fetch(string $billId): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "bills/$billId"
        );
    }
}