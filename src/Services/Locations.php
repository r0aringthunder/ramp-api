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
    public function listLocations($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "locations?$queryParams");
    }

    /**
     * Create a new location.
     */
    public function createLocation($locationData)
    {
        return $this->ramp->sendRequest('POST', 'locations', $locationData);
    }

    /**
     * Fetch a specific location by its ID.
     */
    public function fetchLocation($locationId)
    {
        return $this->ramp->sendRequest('GET', "locations/$locationId");
    }

    /**
     * Update a location.
     */
    public function updateLocation($locationId, $locationData)
    {
        return $this->ramp->sendRequest('PATCH', "locations/$locationId", $locationData);
    }
}
