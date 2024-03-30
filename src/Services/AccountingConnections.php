<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class AccountingConnections
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * Fetch an accounting connection.
     *
     * @return array The response from the Ramp API.
     */
    public function fetchAccountingConnection()
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
    public function registerAccountingConnection($remoteProviderName, $reactivate = false)
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
    public function deleteAccountingConnection()
    {
        return $this->ramp->sendRequest('DELETE', 'accounting/connection');
    }
}
