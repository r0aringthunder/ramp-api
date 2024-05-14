<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class ReceiptIntegrations
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * List emails opted out of receipt integrations.
     */
    public function listOptOutEmails(): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "receipt-integrations/opt-out"
        );
    }

    /**
     * Add a new email to the receipt integrations opt-out list.
     */
    public function addOptOutEmail(string $id, string $email): array
    {
        $data = json_encode([
            "business_id" => $id,
            "email" => $email,
        ]);
        return $this->ramp->sendRequest(
            method: "POST",
            endpoint: "receipt-integrations/opt-out",
            data: "$data"
        );
    }

    /**
     * Remove an email from the receipt integration opt-out list.
     */
    public function removeOptOutEmail(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "DELETE",
            endpoint: "receipt-integrations/opt-out/$id"
        );
    }
}
