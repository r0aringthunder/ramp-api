<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class SpendPrograms
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List spend programs with optional filters.
     */
    public function listSpendPrograms($filters = [])
    {
        $queryParams = http_build_query($filters);
        return $this->ramp->sendRequest('GET', "spend-programs?$queryParams");
    }

    /**
     * Create a new spend program.
     */
    public function createSpendProgram($data)
    {
        return $this->ramp->sendRequest('POST', 'spend-programs', $data);
    }

    /**
     * Fetch a specific spend program by its ID.
     */
    public function fetchSpendProgram($spendProgramId)
    {
        return $this->ramp->sendRequest('GET', "spend-programs/$spendProgramId");
    }
}
