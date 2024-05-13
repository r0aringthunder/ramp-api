<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Memos
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List memos with optional filters.
     */
    public function list(array $filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest(method: "GET", endpoint: "memos?$queryParams");
    }

    /**
     * Fetch a specific transaction memo by its ID.
     */
    public function fetch(string $id)
    {
        return $this->ramp->sendRequest(method: "GET", endpoint: "memos/$id");
    }
}
