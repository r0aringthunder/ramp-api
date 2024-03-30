<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Limits
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List limits with optional filters.
     */
    public function listLimits($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "limits?$queryParams");
    }

    /**
     * Create a limit.
     */
    public function createLimit($limitData)
    {
        return $this->ramp->sendRequest('POST', 'limits/deferred', $limitData);
    }

    /**
     * Fetch deferred task status by its ID.
     */
    public function fetchDeferredTaskStatus($taskId)
    {
        return $this->ramp->sendRequest('GET', "limits/deferred/status/$taskId");
    }

    /**
     * Fetch a specific limit by its ID.
     */
    public function fetchLimit($limitId)
    {
        return $this->ramp->sendRequest('GET', "limits/$limitId");
    }

    /**
     * Update a limit.
     */
    public function updateLimit($limitId, $limitData)
    {
        return $this->ramp->sendRequest('PATCH', "limits/$limitId", $limitData);
    }

    /**
     * Terminate a limit permanently.
     */
    public function terminateLimit($limitId, $idempotencyKey)
    {
        return $this->ramp->sendRequest('POST', "limits/$limitId/deferred/termination", ['idempotency_key' => $idempotencyKey]);
    }

    /**
     * Suspend a limit.
     */
    public function suspendLimit($limitId)
    {
        return $this->ramp->sendRequest('POST', "limits/$limitId/suspension");
    }

    /**
     * Unsuspend a limit.
     */
    public function unsuspendLimit($limitId)
    {
        return $this->ramp->sendRequest('POST', "limits/$limitId/unsuspension");
    }
}
