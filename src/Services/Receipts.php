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
     * @param string $filePath The path to the receipt file or URL.
     * @return array The response from the Ramp API.
     * @throws \Exception If the file does not exist, is not readable, or has an unsupported type.
     */
    public function upload(array $data, string $filePath): array
    {
        list($tmpFilePath, $mimeType) = Helper::getFileDetails($filePath);

        $multipartData = Helper::prepareMultipartData($data, $tmpFilePath, $mimeType);

        $response = $this->ramp->sendMultipartRequest('POST', 'receipts', [], $multipartData);

        unlink($tmpFilePath);

        return $response;
    }
}
