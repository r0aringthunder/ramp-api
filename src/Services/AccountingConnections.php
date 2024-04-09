<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

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
        return $this->ramp->sendRequest('GET', 'accounting/connection');
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
        $data = [
            'reactivate' => $reactivate,
            'remote_provider_name' => $remoteProviderName,
        ];

        return $this->ramp->sendRequest('POST', 'accounting/connection', $data);
    }

    /**
     * Delete an accounting connection.
     *
     * @return array The response from the Ramp API.
     */
    public function delete(): array
    {
        return $this->ramp->sendRequest('DELETE', 'accounting/connection');
    }
}
