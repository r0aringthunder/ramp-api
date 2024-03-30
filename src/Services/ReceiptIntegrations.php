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
    public function listOptOutEmails()
    {
        return $this->ramp->sendRequest('GET', "receipt-integrations/opt-out");
    }

    /**
     * Add a new email to the receipt integrations opt-out list.
     */
    public function addOptOutEmail($businessId, $email)
    {
        $data = [
            'business_id' => $businessId,
            'email' => $email,
        ];
        return $this->ramp->sendRequest('POST', 'receipt-integrations/opt-out', $data);
    }

    /**
     * Remove an email from the receipt integration opt-out list.
     */
    public function removeOptOutEmail($optOutEmailId)
    {
        return $this->ramp->sendRequest('DELETE', "receipt-integrations/opt-out/$optOutEmailId");
    }
}
