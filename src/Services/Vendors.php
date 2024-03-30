<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Vendors
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List vendors with optional filters.
     */
    public function listVendors($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "accounting/vendors?$queryParams");
    }

    /**
     * Upload vendors.
     */
    public function uploadVendors($vendors)
    {
        return $this->ramp->sendRequest('POST', 'accounting/vendors', ['vendors' => $vendors]);
    }

    /**
     * Fetch a specific vendor by their ID.
     */
    public function fetchVendor($vendorId)
    {
        return $this->ramp->sendRequest('GET', "accounting/vendors/$vendorId");
    }

    /**
     * Update a specific vendor by their ID.
     */
    public function updateVendor($vendorId, $vendorData)
    {
        return $this->ramp->sendRequest('PATCH', "accounting/vendors/$vendorId", $vendorData);
    }

    /**
     * Delete a specific vendor by their ID.
     */
    public function deleteVendor($vendorId)
    {
        return $this->ramp->sendRequest('DELETE', "accounting/vendors/$vendorId");
    }
}
