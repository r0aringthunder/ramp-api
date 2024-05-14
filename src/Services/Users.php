<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Users
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List users with optional filters.
     */
    public function list(array $filters = []): array
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "users?$filters"
        );
    }

    /**
     * Create a user invite.
     */
    public function createInvite(array $data): array
    {
        $data = json_encode($data);
        return $this->ramp->sendRequest(
            method: "POST",
            endpoint: "users/deferred",
            data: "$data"
        );
    }

    /**
     * Fetch deferred task status.
     */
    public function fetchDeferredTaskStatus(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "users/deferred/status/$id"
        );
    }

    /**
     * Fetch a specific user by their ID.
     */
    public function fetch(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "users/$id"
        );
    }

    /**
     * Update a specific user by their ID.
     */
    public function update(string $id, array $data): array
    {
        $data = json_encode($data);
        return $this->ramp->sendRequest(
            method: "PATCH",
            endpoint: "users/$id",
            data: "$data"
        );
    }

    /**
     * Delete a specific user by their ID.
     */
    public function delete(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "DELETE",
            endpoint: "users/$id"
        );
    }
}
