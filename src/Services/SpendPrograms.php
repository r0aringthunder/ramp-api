<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Setup\Base;

class SpendPrograms extends Base
{
    /**
     * List spend programs with optional filters.
     */
    public function list(array $filters = []): array
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "spend-programs?$filters"
        );
    }

    /**
     * Create a new spend program.
     */
    public function create(array $data): array
    {
        $data = json_encode($data);
        return $this->ramp->sendRequest(
            method: "POST",
            endpoint: "spend-programs",
            data: "$data"
        );
    }

    /**
     * Fetch a specific spend program by its ID.
     */
    public function fetch(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "spend-programs/$id"
        );
    }
}
