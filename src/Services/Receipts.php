<?php

namespace R0aringthunder\RampApi\Services;

use R0aringthunder\RampApi\Setup\Base;

class Receipts extends Base
{
    /**
     * List receipts with optional filters.
     */
    public function list(array $filters = []): array
    {
        $filters = http_build_query($filters);
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "receipts?$filters"
        );
    }

    /**
     * Fetch a specific receipt by its ID.
     */
    public function fetch(string $id): array
    {
        return $this->ramp->sendRequest(
            method: "GET",
            endpoint: "receipts/$id"
        );
    }

    /**
     * Uploads a receipt.
     *
     * @param array $data The data for the receipt upload.
     * @param string $filePath The path to the receipt file.
     * @return array The response from the Ramp API.
     */
    public function upload(array $data, $filePath): array
    {
        $multipartData = [
            'idempotency_key' => $data['idempotency_key'],
            'transaction_id' => $data['transaction_id'],
            'user_id' => $data['user_id'],
            'file' => new \CURLFile($filePath)
        ];

        return $this->ramp->sendMultipartRequest('POST', 'receipts', [], $multipartData);
    }
}
