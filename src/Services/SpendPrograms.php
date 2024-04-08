<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class SpendPrograms extends Base
{
    /**
     * List spend programs with optional filters.
     */
    public function list($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "spend-programs?$queryParams");
    }

    /**
     * Create a new spend program.
     */
    public function create($data)
    {
        return $this->ramp->sendRequest('POST', 'spend-programs', $data);
    }

    /**
     * Fetch a specific spend program by its ID.
     */
    public function fetch($spendProgramId)
    {
        return $this->ramp->sendRequest('GET', "spend-programs/$spendProgramId");
    }
}
