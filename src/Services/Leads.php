<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Leads
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * Create a sales lead.
     */
    public function create(array $data = [])
    {
        $data = json_encode($data);
        return $this->ramp->sendRequest(method: "POST", endpoint: "leads", data: "$data");
    }

    /**
     * Fetch a specific sales lead by its ID.
     */
    public function fetch(string $id)
    {
        return $this->ramp->sendRequest(method: "GET", endpoint: "leads/$id");
    }

    /**
     * Upload documents required by the financing application process (Deprecated).
     */
    public function upload(string $id, array $data = [])
    {
        // Note: This operation is marked as to be deprecated in the API documentation for a future release.
        $data = json_encode($data);
        return $this->ramp->sendRequest(method: "POST", endpoint: "leads/$id/upload_document", data: $data);
    }
}
