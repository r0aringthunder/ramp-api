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
    public function listDepartments($start = null, $pageSize = null)
    {
        $queryParams = http_build_query(compact('start', 'pageSize'));
        return $this->ramp->sendRequest('GET', "departments?$queryParams");
    }

    /**
     * Create a new department.
     */
    public function createDepartment($name)
    {
        $data = ['name' => $name];
        return $this->ramp->sendRequest('POST', 'departments', $data);
    }

    /**
     * Fetch a specific department by its ID.
     */
    public function fetchDepartment($departmentId)
    {
        return $this->ramp->sendRequest('GET', "departments/$departmentId");
    }

    /**
     * Update a department.
     */
    public function updateDepartment($departmentId, $name)
    {
        $data = ['id' => $departmentId, 'name' => $name];
        return $this->ramp->sendRequest('PATCH', "departments/$departmentId", $data);
    }
}
