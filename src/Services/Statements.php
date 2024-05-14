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
    public function list(array $filters = []): array
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "statements?$filters"
        );
    }

    /**
     * Fetch a specific statement by its ID.
     */
    public function fetch(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "statements/$id"
        );
    }
}
