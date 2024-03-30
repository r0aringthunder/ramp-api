<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Ramp;

class Accounting
{
    protected $ramp;

    public function __construct(Ramp $ramp)
    {
        $this->ramp = $ramp;
    }

    public function listFieldOptions($fieldId, $pageSize = null, $start = null, $isActive = null)
    {
        $queryParams = http_build_query([
            'field_id' => $fieldId,
            'page_size' => $pageSize,
            'start' => $start,
            'is_active' => $isActive,
        ]);

        return $this->ramp->sendRequest('GET', "accounting/field-options?$queryParams");
    }

    public function uploadFieldOptions($fieldId, array $options)
    {
        $data = [
            'field_id' => $fieldId,
            'options' => $options,
        ];

        return $this->ramp->sendRequest('POST', 'accounting/field-options', $data);
    }

    public function fetchFieldOption($fieldOptionId)
    {
        return $this->ramp->sendRequest('GET', "accounting/field-options/$fieldOptionId");
    }

    public function updateFieldOption($fieldOptionId, $value = null, $reactivate = null)
    {
        $data = array_filter([
            'value' => $value,
            'reactivate' => $reactivate,
        ]);

        return $this->ramp->sendRequest('PATCH', "accounting/field-options/$fieldOptionId", $data);
    }

    public function deleteFieldOption($fieldOptionId)
    {
        return $this->ramp->sendRequest('DELETE', "accounting/field-options/$fieldOptionId");
    }
}
