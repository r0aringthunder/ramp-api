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
        return $this->ramp->sendRequest(method: "GET", endpoint: "limits?$queryParams");
    }

    /**
     * Create a limit.
     */
    public function createLimit($data)
    {
        $data = json_encode($data);
        return $this->ramp->sendRequest(method: "POST", endpoint: "limits/deferred", data: "$data");
    }

    /**
     * Fetch deferred task status by its ID.
     */
    public function fetchDeferredTaskStatus($id)
    {
        return $this->ramp->sendRequest(method: "GET", endpoint: "limits/deferred/status/$id");
    }

    /**
     * Fetch a specific limit by its ID.
     */
    public function fetchLimit($id)
    {
        return $this->ramp->sendRequest(method: "GET", endpoint: "limits/$id");
    }

    /**
     * Update a limit.
     */
    public function updateLimit($id, $data)
    {
        $data = json_encode($data);
        return $this->ramp->sendRequest(method: "PATCH", endpoint: "limits/$id", data: "$data");
    }

    /**
     * Terminate a limit permanently.
     */
    public function terminateLimit($id, $idempotencyKey)
    {
        $data = json_encode(["idempotency_key" => $idempotencyKey]);
        return $this->ramp->sendRequest(method: "POST", endpoint: "limits/$id/deferred/termination", data: "$data");
    }

    /**
     * Suspend a limit.
     */
    public function suspendLimit($id)
    {
        return $this->ramp->sendRequest(method: "POST", endpoint: "limits/$id/suspension");
    }

    /**
     * Unsuspend a limit.
     */
    public function unsuspendLimit($id)
    {
        return $this->ramp->sendRequest(method: "POST", endpoint: "limits/$id/unsuspension");
    }
}
