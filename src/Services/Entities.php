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
    public function listEntities($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "entities?$queryParams");
    }

    /**
     * Fetch a specific business entity by its ID.
     */
    public function fetchEntity($entityId)
    {
        return $this->ramp->sendRequest('GET', "entities/$entityId");
    }
}
