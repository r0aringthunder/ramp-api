<?php

namespace R0aringthunder\RampApi\Services;

use Illuminate\Support\Facades\Http;
use R0aringthunder\RampApi\Setup\Base;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\JsonResponse;

class Helpers extends Base
{
    /**
     * Download a blob from a list of URLs.
     */
    public function getBlob(string $imageUrl): StreamedResponse|JsonResponse
    {
        if (empty($imageUrl)) {
            return response()->json(['error' => 'No URL provided'], 400);
        }

        $response = Http::get($imageUrl);

        if ($response->failed()) {
            return response()->json(['url' => $imageUrl, 'status' => 'failed', 'error' => 'Unable to download file'], 500);
        }

        // Parse the URL to remove query parameters
        $parsedUrl = parse_url($imageUrl);
        $path = $parsedUrl['path'];

        // Get the file name and extension
        $fileName = basename($path);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileBaseName = pathinfo($fileName, PATHINFO_FILENAME);
        $downloadFileName = $fileBaseName . '.' . $fileExtension;

        // Create a streamed response
        $streamedResponse = new StreamedResponse(function() use ($response) {
            echo $response->body();
        });

        // Set the headers for the download
        $streamedResponse->headers->set('Content-Type', 'application/octet-stream');
        $streamedResponse->headers->set('Content-Disposition', 'attachment; filename="' . $downloadFileName . '"');
        $streamedResponse->headers->set('Content-Length', strlen($response->body()));

        return $streamedResponse;
    }
}
