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
    public function listUsers($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "users?$queryParams");
    }

    /**
     * Create a user invite.
     */
    public function createUserInvite($userData)
    {
        return $this->ramp->sendRequest('POST', 'users/deferred', $userData);
    }

    /**
     * Fetch deferred task status.
     */
    public function fetchDeferredTaskStatus($taskId)
    {
        return $this->ramp->sendRequest('GET', "users/deferred/status/$taskId");
    }

    /**
     * Fetch a specific user by their ID.
     */
    public function fetchUser($userId)
    {
        return $this->ramp->sendRequest('GET', "users/$userId");
    }

    /**
     * Update a specific user by their ID.
     */
    public function updateUser($userId, $userData)
    {
        return $this->ramp->sendRequest('PATCH', "users/$userId", $userData);
    }

    /**
     * Delete a specific user by their ID.
     */
    public function deleteUser($userId)
    {
        return $this->ramp->sendRequest('DELETE', "users/$userId");
    }
}
