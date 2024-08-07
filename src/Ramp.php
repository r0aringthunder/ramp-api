<?php

namespace R0aringthunder\RampApi;

use FilesystemIterator;
use SplFileInfo;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class Ramp serves as the main entry point to interact with Ramp API, managing authentication and service requests.
 */
class Ramp
{
    protected $enabled;
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $accessToken;
    private $services = [];

    /**
     * Constructs the Ramp instance, initializing configurations and registering available services.
     */
    public function __construct()
    {
        $this->initialize();
        $this->registerAvailableServices();
    }

    /**
     * Initializes client credentials and base URL for API requests.
     * 
     * Retrieves client credentials and the base URL configuration, then obtains an initial access token.
     */
    protected function initialize()
    {
        if (!config("ramp.enabled")) {
            Log::error("Ramp API is not enabled. To enable it, set RAMP_ENABLED to true in your .env file.");
            return;
        }
        $this->clientId = config("ramp.client_id");
        $this->clientSecret = config("ramp.client_secret");
        $this->baseUrl = config("ramp.prod_ready") ? "https://api.ramp.com/developer/v1/" : "https://demo-api.ramp.com/developer/v1/";
        $this->obtainAccessToken();
    }

    /**
     * Obtains an access token using the Client Credentials grant.
     *
     * This method authenticates with the Ramp API using client credentials to obtain an access token.
     * 
     * @return array The response from the token endpoint, including the access token.
     */
    public function obtainAccessToken()
    {
        $this->clientId = config("ramp.client_id");
        $this->clientSecret = config("ramp.client_secret");
        $scopes = config("ramp.scopes");

        $response = $this->sendRequest("POST", "token", [
            "Content-Type: application/x-www-form-urlencoded",
        ], http_build_query([
            "grant_type" => "client_credentials",
            "scope" => $scopes,
        ]));
        
        if (isset($response["access_token"])) {
            $this->accessToken = $response["access_token"];
        }

        return $response;
    }

    /**
     * Sends a request to the Ramp API.
     * 
     * This method constructs and sends an HTTP request to the Ramp API, handling authorization and content encoding.
     *
     * @param string $method The HTTP method to use for the request.
     * @param string $endpoint The API endpoint to request.
     * @param array $headers Additional HTTP headers to include in the request.
     * @param mixed $data The data to be sent with the request.
     * @param bool $addAuthHeader Indicates whether to add an Authorization header with a Bearer token.
     * @return mixed The JSON-decoded response from the API.
     * @throws Exception If a cURL error occurs during the request.
     */
    public function sendRequest($method, $endpoint, $headers = [], $data = null)
    {
        $curl = curl_init();
        $url = $this->baseUrl . $endpoint;

        if ($endpoint === "token") {
            $credentials = base64_encode($this->clientId . ":" . $this->clientSecret);
            $headers[] = "Authorization: Basic " . $credentials;
        } elseif ($this->accessToken) {
            $headers[] = "Authorization: Bearer " . $this->accessToken;
        }

        if($method === "POST" || $method === "PATCH") {
            $headers[] = "Content-Type: application/json";
        }

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $headers
        ];
    
        // Ensure data is JSON encoded if required
        if ($data !== null && ($method === "POST" || $method === "PATCH")) {
            $options[CURLOPT_POSTFIELDS] = $data;
        }
    
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
    
        if ($err) {
            throw new Exception("cURL Error: " . $err);
        }
    
        return json_decode($response, true);
    }

    /**
     * Sends a multipart/form-data request to the Ramp API.
     *
     * @param string $method The HTTP method to use for the request.
     * @param string $endpoint The API endpoint to request.
     * @param array $headers Additional HTTP headers to include in the request.
     * @param array $data The data to be sent with the request.
     * @return mixed The JSON-decoded response from the API.
     * @throws Exception If a cURL error occurs during the request.
     */
    public function sendMultipartRequest($method, $endpoint, $headers = [], $data = [])
    {
        $curl = curl_init();

        $url = $this->baseUrl . $endpoint;
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_POST => true,
        ];

        if ($this->accessToken) {
            $headers[] = 'Authorization: Bearer ' . $this->accessToken;
        }

        $delimiter = '-------------' . self::generateIdempotencyKey();

        $headers[] = 'Content-Type: multipart/form-data; boundary=' . $delimiter;

        $body = $this->buildMultipartBody($data, $delimiter);

        $options[CURLOPT_HTTPHEADER] = $headers;
        $options[CURLOPT_POSTFIELDS] = $body;

        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error: " . $err);
        }

        return json_decode($response, true);
    }

    private function buildMultipartBody($fields, $delimiter)
    {
        $data = '';
    
        foreach ($fields as $field) {
            $data .= "--" . $delimiter . "\r\n";
            $data .= 'Content-Disposition: form-data; name="' . $field['name'] . '"';
            if (isset($field['filename'])) {
                $data .= '; filename="' . $field['filename'] . '"';
            }
            $data .= "\r\n";
            if (isset($field['headers'])) {
                foreach ($field['headers'] as $headerName => $headerValue) {
                    $data .= $headerName . ": " . $headerValue . "\r\n";
                }
            }
            $data .= "\r\n";
            if (isset($field['contents']) && is_resource($field['contents'])) {
                $data .= stream_get_contents($field['contents']) . "\r\n";
            } else {
                $data .= $field['contents'] . "\r\n";
            }
        }
        $data .= "--" . $delimiter . "--\r\n";
    
        return $data;
    }

    /**
     * Magic getter to lazy-load service instances.
     * 
     * If the requested service is not initialized, it will initialize it on the first access.
     *
     * @param string $name The name of the service to get.
     * @return mixed|null The service instance or null if it doesn't exist.
     */
    public function __get($name)
    {
        if (isset($this->services[$name]) && is_string($this->services[$name])) {
            $className = $this->services[$name];
            $this->services[$name] = new $className($this);
        }
        return $this->services[$name] ?? null;
    }

    /**
     * Registers all available services by discovering them in the Services directory.
     * 
     * This method scans the Services directory and registers all found services.
     */
    private function registerAvailableServices()
    {
        $serviceMap = $this->discoverServices();
        foreach ($serviceMap as $serviceName => $className) {
            $this->services[$serviceName] = $className;
        }
    }

    /**
     * Discovers service classes in the Services directory and maps their filenames to class names.
     * 
     * This method scans the Services directory for PHP files and constructs a map of service names to their fully qualified class names.
     *
     * @return array The map of service names to their fully qualified class names.
     */
    protected function discoverServices()
    {
        $directory = __DIR__ . "/Services";
        $serviceMap = [];

        foreach (new FilesystemIterator($directory) as $fileInfo) {
            if ($fileInfo->isFile() && $fileInfo->getExtension() === "php" && $fileInfo->getFilename() !== "Base.php" && $fileInfo->getFilename() !== "Helper.php") {
                $className = str_replace(".php", "", $fileInfo->getFilename());
                $fullyQualifiedClassName = __NAMESPACE__ . "\\Services\\" . $className;
                $serviceName = lcfirst($className);
                $serviceMap[$serviceName] = $fullyQualifiedClassName;
            }
        }
        return $serviceMap;
    }

    /**
     * Generates an idempotency_key for use in API requests.
     * 
     * @return string The generated idempotency key.
     */
    public function generateIdempotencyKey()
    {
        return config("ramp.idempotency_key_prefix", date('Y_m_d_H_i_s_a_')) . uniqid();
    }
}