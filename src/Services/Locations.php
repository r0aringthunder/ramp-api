<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Locations extends Base
{
    /**
     * List locations with optional filters.
     */
    public function list($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "locations?$queryParams");
    }

    /**
     * Create a new location.
     */
    public function create($locationData)
    {
        return $this->ramp->sendRequest('POST', 'locations', $locationData);
    }

    /**
     * Fetch a specific location by its ID.
     */
    public function fetch($locationId)
    {
        return $this->ramp->sendRequest('GET', "locations/$locationId");
    }

    /**
     * Update a location.
     */
    public function update($locationId, $locationData)
    {
        return $this->ramp->sendRequest('PATCH', "locations/$locationId", $locationData);
    }
}
