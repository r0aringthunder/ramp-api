<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Setup\Base;

/**
 * Provides methods to interact with accounting-related endpoints of the Ramp API.
 */
class Accounting extends Base
{
    /**
     * Lists options for a given custom accounting field.
     *
     * @param string      $fieldId   The ID of the custom accounting field.
     * @param int|null    $pageSize  The number of results to return per page. Optional.
     * @param string|null $start     The starting point for pagination (UUID). Optional.
     * @param bool|null   $isActive  Whether to filter the results by active status. Optional.
     * @return array The response from the Ramp API.
     */
    public function listOptions(string $fieldId, int|null $pageSize = null, string|null $start = null, bool|null $isActive = null): array
    {
        $filters = http_build_query([
            "field_id" => $fieldId,
            "page_size" => $pageSize,
            "start" => $start,
            "is_active" => $isActive,
        ]);

        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "accounting/field-options?$filters"
        );
    }

    /**
     * Uploads new options for a given custom accounting field.
     *
     * @param string $fieldId The ID of the custom accounting field.
     * @param array  $options An array of options to be uploaded.
     * @return array The response from the Ramp API.
     */
    public function uploadOptions(string $fieldId, array $options = []): array
    {
        $data = [
            "field_id" => $fieldId,
            "options" => $options,
        ];

        return $this->ramp->sendRequest(
            method: "POST",
            endpoint: "accounting/field-options",
            data: $data
        );
    }

    /**
     * Fetches a specific custom accounting field option by its ID.
     *
     * @param string $fieldId The ID of the custom field option to fetch.
     * @return array The response from the Ramp API.
     */
    public function fetchOption(string $fieldId): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "accounting/field-options/$fieldId"
        );
    }

    /**
     * Updates a specific custom accounting field option by its ID.
     *
     * @param string      $fieldId The ID of the custom field option to update.
     * @param string|null $value         The new value for the field option. Optional.
     * @param bool|null   $reactivate    Whether to reactivate the field option. Optional.
     * @return array The response from the Ramp API.
     */
    public function updateOption(string $fieldId, string|null $value = null, bool|null $reactivate = null): array
    {
        $data = array_filter([
            "value" => $value,
            "reactivate" => $reactivate,
        ]);

        return $this->ramp->sendRequest(
            method: "PATCH",
            endpoint: "accounting/field-options/$fieldId",
            data: $data
        );
    }

    /**
     * Deletes a specific custom accounting field option by its ID.
     *
     * @param string $fieldId The ID of the custom field option to delete.
     * @return array The response from the Ramp API.
     */
    public function deleteOption(string $fieldId): array
    {
        return $this->ramp->sendRequest(
            method: "DELETE",
            endpoint: "accounting/field-options/$fieldId"
        );
    }

    // New accounting to be added before major release
    // https://docs.ramp.com/developer-api/v1/reference/rest/accounting
}
