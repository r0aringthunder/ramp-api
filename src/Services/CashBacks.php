<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

/**
 * Provides methods to interact with cash back-related endpoints of the Ramp API.
 */
class CashBacks
{
    /**
     * @var Ramp The Ramp service instance to handle API requests.
     */
    protected $ramp;

    /**
     * Initializes a new instance of the Cash Backs service.
     *
     * @param Ramp $ramp The Ramp service instance.
     */
    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * Lists cashback payments with optional filtering.
     * @param array $filters An associative array of query parameters for filtering the list of cashback payments.
     *                       Possible keys include "entity_id", "statement_id", "from_date", "to_date", "start", "page_size".
     * @return array The response from the Ramp API.
     */
    public function list(array $filters = []): array
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "cashbacks?$filters"
        );
    }

    /**
     * Fetches detailed information about a specific cashback payment by its ID.
     *
     * @param string $cashbackId The unique identifier of the cashback payment to fetch.
     * @return array The response from the Ramp API.
     */
    public function fetch(string $cashbackId): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "cashbacks/$cashbackId"
        );
    }
}
