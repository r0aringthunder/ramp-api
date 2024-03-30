<?php

namespace R0aringthunder\RampApi;

use FilesystemIterator;
use SplFileInfo;

class Ramp
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $accessToken;
    private $services = [];

    public function __construct()
    {
        $this->initialize();
        $this->registerAvailableServices();
    }

    protected function initialize()
    {
        $this->clientId = config('ramp.client_id');
        $this->clientSecret = config('ramp.client_secret');
        $this->baseUrl = config('ramp.prod_ready') ? 'https://api.ramp.com/developer/v1/' : 'https://demo-api.ramp.com/developer/v1/';
        $this->obtainAccessTokenWithClientCredentials();
    }

    /**
     * Obtain an access token using the Client Credentials grant.
     */
    public function obtainAccessTokenWithClientCredentials()
    {
        $this->clientId = config('ramp.client_id');
        $this->clientSecret = config('ramp.client_secret');
        $scopes = config('ramp.scopes');

        $response = $this->sendRequest('POST', 'token', [
            'Content-Type: application/x-www-form-urlencoded',
        ], http_build_query([
            'grant_type' => 'client_credentials',
            'scope' => $scopes,
        ]), false);

        if (isset($response['access_token'])) {
            $this->accessToken = $response['access_token'];
        }

        return $response;
    }

    /**
     * Sends a request to the Ramp API.
     *
     * @param string $method HTTP method
     * @param string $endpoint API endpoint
     * @param array $headers Additional headers
     * @param mixed $data Data to be sent with the request
     * @param bool $addAuthHeader Whether to add the Authorization header with the Bearer token
     * @return mixed The JSON-decoded response
     */
    public function sendRequest($method, $endpoint, $headers = [], $data = null, $addAuthHeader = true)
    {
        $curl = curl_init();

        $url = $this->baseUrl . $endpoint;
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
        ];

        if (!$addAuthHeader) {
            $credentials = base64_encode($this->clientId . ':' . $this->clientSecret);
            $headers[] = 'Authorization: Basic ' . $credentials;
        } elseif ($this->accessToken) {
            $headers[] = 'Authorization: Bearer ' . $this->accessToken;
        }

        if (!empty($headers)) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        if (!empty($data)) {
            if ($method === 'POST' || $method === 'PATCH') {
                $options[CURLOPT_POSTFIELDS] = $data;
            }
        }

        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new \Exception("cURL Error: " . $err);
        }

        return json_decode($response, true);
    }

    public function __get($name)
    {
        if (isset($this->services[$name]) && is_string($this->services[$name])) {
            $className = $this->services[$name];
            $this->services[$name] = new $className($this);
        }
        return $this->services[$name] ?? null;
    }

    private function registerAvailableServices()
    {
        $serviceMap = $this->discoverServices();
        foreach ($serviceMap as $serviceName => $className) {
            $this->services[$serviceName] = $className;
        }
    }

    protected function discoverServices()
    {
        $directory = __DIR__ . '/Services';
        $serviceMap = [];

        foreach (new FilesystemIterator($directory) as $fileInfo) {
            if ($fileInfo->isFile() && $fileInfo->getExtension() === 'php') {
                $className = str_replace('.php', '', $fileInfo->getFilename());
                $fullyQualifiedClassName = __NAMESPACE__ . "\\Services\\" . $className;
                $serviceName = lcfirst($className);
                $serviceMap[$serviceName] = $fullyQualifiedClassName;
            }
        }
        return $serviceMap;
    }
}