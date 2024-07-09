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
        list($tmpFilePath, $mimeType) = $this->getFileDetails($filePath);

        $multipartData = $this->prepareMultipartData($data, $tmpFilePath, $mimeType);

        $response = $this->ramp->sendMultipartRequest('POST', 'receipts', [], $multipartData);

        unlink($tmpFilePath);

        return $response;
    }

    /**
     * Get file details from a URL or local file path.
     *
     * @param string $filePath The path to the receipt file or URL.
     * @return array An array containing the temporary file path and MIME type.
     * @throws Exception If unable to process the file.
     */
    private function getFileDetails(string $filePath): array
    {
        if (filter_var($filePath, FILTER_VALIDATE_URL)) {
            return $this->handleFileFromUrl($filePath);
        } else {
            return $this->handleLocalFile($filePath);
        }
    }

    /**
     * Handle file download from URL.
     *
     * @param string $fileUrl The URL of the file.
     * @return array An array containing the temporary file path and MIME type.
     * @throws Exception If unable to download or process the file.
     */
    private function handleFileFromUrl(string $fileUrl): array
    {
        $fileContents = file_get_contents($fileUrl);
        if ($fileContents === false) {
            throw new Exception("Unable to download file from URL: $fileUrl");
        }

        $extension = pathinfo($fileUrl, PATHINFO_EXTENSION);
        $mimeType = $this->getMimeTypeFromExtension($extension);
        if ($mimeType === null) {
            throw new Exception("Unsupported file type: $extension");
        }

        $tmpFilePath = tempnam(sys_get_temp_dir(), 'upload_') . '.' . $extension;
        file_put_contents($tmpFilePath, $fileContents);

        return [$tmpFilePath, $mimeType];
    }

    /**
     * Handle local file path processing.
     *
     * @param string $filePath The local file path.
     * @return array An array containing the temporary file path and MIME type.
     * @throws Exception If the file does not exist, is not readable, or has an unsupported type.
     */
    private function handleLocalFile(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new Exception("File does not exist: $filePath");
        }

        if (!is_readable($filePath)) {
            throw new Exception("File is not readable: $filePath");
        }

        $mimeType = mime_content_type($filePath);
        $extension = $this->getExtensionFromMimeType($mimeType);
        if ($extension === null) {
            throw new Exception("Unsupported file type: $mimeType");
        }

        $tmpFilePath = tempnam(sys_get_temp_dir(), 'upload_') . '.' . $extension;
        copy($filePath, $tmpFilePath);

        return [$tmpFilePath, $mimeType];
    }

    /**
     * Prepare multipart data for the request.
     *
     * @param array $data The data for the receipt upload.
     * @param string $tmpFilePath The path to the temporary file.
     * @param string $mimeType The MIME type of the file.
     * @return array The multipart data array.
     */
    private function prepareMultipartData(array $data, string $tmpFilePath, string $mimeType): array
    {
        return [
            [
                'name' => 'idempotency_key',
                'contents' => $this->ramp->generateIdempotencyKey()
            ],
            [
                'name' => 'transaction_id',
                'contents' => $data['transaction_id']
            ],
            [
                'name' => 'user_id',
                'contents' => $data['user_id']
            ],
            [
                'name' => 'receipt',
                'contents' => fopen($tmpFilePath, 'r'),
                'filename' => basename($tmpFilePath),
                'headers' => ['Content-Type' => $mimeType]
            ]
        ];
    }

    /**
     * Get the file extension based on the MIME type.
     *
     * @param string $mimeType
     * @return string|null
     */
    private function getExtensionFromMimeType(string $mimeType): ?string
    {
        $mimeTypes = [
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/heif' => 'heif',
            'application/pdf' => 'pdf',
            'image/heic' => 'heic',
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg'
        ];

        return $mimeTypes[$mimeType] ?? null;
    }

    /**
     * Get the MIME type based on the file extension.
     *
     * @param string $extension
     * @return string|null
     */
    private function getMimeTypeFromExtension(string $extension): ?string
    {
        $extensions = [
            'png' => 'image/png',
            'webp' => 'image/webp',
            'heif' => 'image/heif',
            'pdf' => 'application/pdf',
            'heic' => 'image/heic',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg'
        ];

        return $extensions[strtolower($extension)] ?? null;
    }
}
