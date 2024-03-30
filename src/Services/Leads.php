<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Leads
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    /**
     * Create a sales lead.
     */
    public function createLead($leadData)
    {
        return $this->ramp->sendRequest('POST', 'leads', $leadData);
    }

    /**
     * Fetch a specific sales lead by its ID.
     */
    public function fetchLead($salesLeadId)
    {
        return $this->ramp->sendRequest('GET', "leads/$salesLeadId");
    }

    /**
     * Upload documents required by the financing application process (Deprecated).
     */
    public function uploadDocument($salesLeadId, $documentData)
    {
        // Note: This operation is marked as deprecated in the API documentation.
        return $this->ramp->sendRequest('POST', "leads/$salesLeadId/upload_document", $documentData);
    }
}
