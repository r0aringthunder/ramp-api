<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Departments extends Base
{
    /**
     * List departments with optional pagination.
     */
    public function list($start = null, $pageSize = null)
    {
        $queryParams = http_build_query(compact('start', 'pageSize'));
        return $this->ramp->sendRequest('GET', "departments?$queryParams");
    }

    /**
     * Create a new department.
     */
    public function create($name)
    {
        $data = ['name' => $name];
        return $this->ramp->sendRequest('POST', 'departments', $data);
    }

    /**
     * Fetch a specific department by its ID.
     */
    public function fetch($departmentId)
    {
        return $this->ramp->sendRequest('GET', "departments/$departmentId");
    }

    /**
     * Update a department.
     */
    public function update($departmentId, $name)
    {
        $data = ['id' => $departmentId, 'name' => $name];
        return $this->ramp->sendRequest('PATCH', "departments/$departmentId", $data);
    }
}
