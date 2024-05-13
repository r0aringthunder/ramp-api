<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Entities
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List business entities with optional filtering.
     */
    public function list(array $filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest(method: "GET", endpoint: "entities?$queryParams");
    }

    /**
     * Fetch a specific business entity by its ID.
     */
    public function fetch(string $id)
    {
        return $this->ramp->sendRequest(method: "GET", endpoint: "entities/$id");
    }
}
