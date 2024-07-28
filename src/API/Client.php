<?php

declare(strict_types=1);

namespace Lexoffice\API;

use Lexoffice\Contracts\Interfaces\API\ApiClientInterface;
use Lexoffice\Exceptions\ApiException;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

class Client implements ApiClientInterface {
    public const MIN_INTERVAL = 0.5;
    private bool $sleepAfterRequest;
    private float $lastRequestTime = 0.0;
    private float $requestInterval = 0.65;

    private HttpClient $client;
    private ?LoggerInterface $logger;

    public function __construct(string $apiKey, string $baseUrl = 'https://api.lexoffice.io/v1/', ?LoggerInterface $logger = null, bool $sleepAfterRequest = false) {
        $this->client = new HttpClient([
            'base_uri' => $baseUrl,
            'timeout' => 2.0,
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->sleepAfterRequest = $sleepAfterRequest;
        $this->logger = $logger;
    }

    public function setRequestInterval(float $requestInterval): void {
        if ($requestInterval < Client::MIN_INTERVAL) {
            throw new \InvalidArgumentException('Request interval must be at least ' . Client::MIN_INTERVAL . ' seconds');
        }
        $this->requestInterval = $requestInterval;
    }

    public function getRequestInterval(): float {
        return $this->requestInterval;
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
        $microsecondsToSleep = 0;

        if ($timeSinceLastRequest < $this->requestInterval) {
            $microsecondsToSleep = (int)(($this->requestInterval - $timeSinceLastRequest) * 1e6);
            usleep($microsecondsToSleep);
        }

        $this->lastRequestTime = microtime(true);

        if ($this->logger) {
            $this->logger->info("Sending {$method} request to {$uri} (sleeped for {$microsecondsToSleep} microseconds)", $options);
        }

        $response = $this->client->request($method, $uri, $options);
        if ($this->sleepAfterRequest) {
            // Sleep for 0.5 seconds after each request to avoid rate limiting
            usleep((int)(Client::MIN_INTERVAL * 1e6));
        }

        if ($response->getStatusCode() >= 400) {
            throw new ApiException('Error: ' . $response->getReasonPhrase(), $response->getStatusCode());
        }

        return $response;
    }
}
