<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Receipts
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List receipts with optional filters.
     */
    public function list(array $filters = []): array
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "receipts?$filters"
        );
    }

    /**
     * Fetch a specific receipt by its ID.
     */
    public function fetch(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "receipts/$id"
        );
    }
}
