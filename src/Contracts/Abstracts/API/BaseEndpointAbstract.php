<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use Lexoffice\Contracts\Interfaces\API\ApiClientInterface;
use Lexoffice\Contracts\Interfaces\API\BaseEndpointInterface;
use Lexoffice\Exceptions\ApiException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseEndpointAbstract implements BaseEndpointInterface {
    protected ?LoggerInterface $logger;

    protected ApiClientInterface $client;
    protected string $endpoint;

    public function __construct(ApiClientInterface $client, ?LoggerInterface $logger = null) {
        $this->client = $client;
        $this->logger = $logger;
    }

    protected function getContents(array $queryParams = [], array $options = [], string $urlPath = null, int $statusCode = 200): string {
        if (is_null($urlPath)) {
            $urlPath = $this->endpoint;
        }
        $queryString = http_build_query($queryParams);
        $response = $this->client->get("{$urlPath}?{$queryString}", $options);

        return $this->handleResponse($response, $statusCode);;
    }

    protected function handleResponse(ResponseInterface $response, int $expectedStatusCode): string {
        $statusCode = $response->getStatusCode();

        if ($statusCode !== $expectedStatusCode) {
            throw new ApiException('Unexpected response status code', $statusCode, $response);
        }

        if ($statusCode === 204) {
            return "success";
        }

        return $response->getBody()->getContents();
    }
}
