<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Setup\Base;

class Vendors extends Base
{
    /**
     * List vendors with optional filters.
     */
    public function list(array $filters = []): array
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            "GET",
            "accounting/vendors?$filters"
        );
    }

    /**
     * Upload vendors.
     */
    public function upload(array $data): array
    {
        $data = json_encode(["vendors" => $data]);
        return $this->ramp->sendRequest(
            method: "POST",
            endpoint: "accounting/vendors",
            data: "$data"
        );
    }

    /**
     * Fetch a specific vendor by their ID.
     */
    public function fetch(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "accounting/vendors/$id"
        );
    }

    /**
     * Update a specific vendor by their ID.
     */
    public function update(string $id, array $data): array
    {
        $data = json_encode($data);
        return $this->ramp->sendRequest(
            method: "PATCH",
            endpoint: "accounting/vendors/$id",
            data: "$data"
        );
    }

    /**
     * Delete a specific vendor by their ID.
     */
    public function delete(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "DELETE",
            endpoint: "accounting/vendors/$id"
        );
    }
}
