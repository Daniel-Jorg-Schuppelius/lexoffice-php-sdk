<?php

declare(strict_types=1);

namespace Lexoffice\API;

use Lexoffice\Contracts\Interfaces\API\ApiClientInterface;
use Lexoffice\Exceptions\ApiException;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

class Client implements ApiClientInterface {
    const MIN_INTERVAL = 0.65;

    private HttpClient $client;
    private ?LoggerInterface $logger;
    private float $lastRequestTime = 0.0;

    public function __construct(string $apiKey, string $baseUrl = 'https://api.lexoffice.io/v1/', ?LoggerInterface $logger = null) {
        $this->client = new HttpClient([
            'base_uri' => $baseUrl,
            'timeout' => 2.0,
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->logger = $logger;
    }

    public function get(string $uri, array $options = []): ResponseInterface {
        return $this->request('GET', $uri, $options);
    }

    public function post(string $uri, array $options = []): ResponseInterface {
        return $this->request('POST', $uri, $options);
    }

    public function put(string $uri, array $options = []): ResponseInterface {
        return $this->request('PUT', $uri, $options);
    }

    public function delete(string $uri, array $options = []): ResponseInterface {
        return $this->request('DELETE', $uri, $options);
    }

    private function request(string $method, string $uri, array $options = []): ResponseInterface {
        $timeSinceLastRequest = microtime(true) - $this->lastRequestTime;

        if ($timeSinceLastRequest < Client::MIN_INTERVAL) {
            $microsecondsToSleep = (int)((Client::MIN_INTERVAL - $timeSinceLastRequest) * 1e6);
            error_log("Sleeping for {$microsecondsToSleep} microseconds");
            usleep($microsecondsToSleep);
        }

        $this->lastRequestTime = microtime(true);

        if ($this->logger) {
            $this->logger->info("Sending {$method} request to {$uri}", $options);
        }

        $response = $this->client->request($method, $uri, $options);

        if ($response->getStatusCode() >= 400) {
            throw new ApiException('Error: ' . $response->getReasonPhrase(), $response->getStatusCode());
        }

        return $response;
    }
}
