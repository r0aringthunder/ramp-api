<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Setup\Base;

/**
 * Provides methods to interact with accounting connections-related endpoints of the Ramp API.
 */
class AccountingConnections extends Base
{
    /**
     * Fetch an accounting connection.
     *
     * @return array The response from the Ramp API.
     */
    public function fetch(): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "accounting/connection"
        );
    }

    /**
     * Register a new accounting connection.
     *
     * @param string $remoteProviderName Name of the ERP system.
     * @param bool $reactivate Attempt to reactivate a deleted connection.
     * @return array The response from the Ramp API.
     */
    public function register(string $remoteProviderName, bool $reactivate = false): array
    {
        $data = json_encode([
            "reactivate" => $reactivate,
            "remote_provider_name" => $remoteProviderName,
        ]);
        return $this->ramp->sendRequest(
            method: "POST",
            endpoint: "accounting/connection",
            data: "$data"
        );
    }

    /**
     * Delete an accounting connection.
     *
     * @return array The response from the Ramp API.
     */
    public function delete(): array
    {
        return $this->ramp->sendRequest(
            method: "DELETE",
            endpoint: "accounting/connection"
        );
    }
}
