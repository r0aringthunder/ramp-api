<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Locations
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List locations with optional filters.
     */
    public function list(array $filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest(method: "GET", endpoint: "locations?$queryParams");
    }

    /**
     * Create a new location.
     */
    public function create(array $data)
    {
        $data = json_encode($data);
        return $this->ramp->sendRequest(method: "POST", endpoint: "locations", data: "$data");
    }

    /**
     * Fetch a specific location by its ID.
     */
    public function fetch(string $id)
    {
        return $this->ramp->sendRequest(method: "GET", endpoint: "locations/$id");
    }

    /**
     * Update a location.
     */
    public function update(string $id, array $data)
    {
        $data = json_encode($data);
        return $this->ramp->sendRequest(method: "PATCH", endpoint: "locations/$id", data: "$data");
    }
}
