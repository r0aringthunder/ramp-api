<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Departments
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List departments with optional pagination.
     */
    public function list(string $start = null, int $pageSize = null)
    {
        $filters = http_build_query(compact("start", "pageSize"));
        return $this->ramp->sendRequest("GET", "departments?$filters");
    }

    /**
     * Create a new department.
     */
    public function create(string $name)
    {
        $data = json_encode(["name" => $name]);
        return $this->ramp->sendRequest(
            method: "POST",
            endpoint: "departments",
            data: "$data"
        );
    }

    /**
     * Fetch a specific department by its ID.
     */
    public function fetch(string $departmentId)
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "departments/$departmentId"
        );
    }

    /**
     * Update a department.
     */
    public function update(string $id, string $name)
    {
        $data = json_encode(["id" => $id, "name" => $name]);
        return $this->ramp->sendRequest(
            method: "PATCH",
            endpoint: "departments/$id",
            data: "$data"
        );
    }
}
