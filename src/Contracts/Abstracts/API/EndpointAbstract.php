<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use Lexoffice\Contracts\Interfaces\API\ApiClientInterface;
use Lexoffice\Contracts\Interfaces\API\EndpointInterface;
use Lexoffice\Contracts\Interfaces\API\ResourceInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Exceptions\ApiException;
use Lexoffice\Exceptions\NotFoundException;
use Lexoffice\Exceptions\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;

abstract class EndpointAbstract implements EndpointInterface {
    protected ApiClientInterface $client;
    protected string $endpoint;

    public function __construct(ApiClientInterface $client) {
        $this->client = $client;
    }

    protected function handleResponse(ResponseInterface $response, int $expectedStatusCode): array {
        $statusCode = $response->getStatusCode();

        if ($statusCode === 404) {
            throw new NotFoundException('Resource not found', 404, $response);
        } elseif ($statusCode === 401) {
            throw new UnauthorizedException('Unauthorized', 401, $response);
        } elseif ($statusCode !== $expectedStatusCode) {
            throw new ApiException('Unexpected response status code', $statusCode, $response);
        }

        if ($statusCode === 204) {
            return [];
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    abstract public function create(array $data): ResourceInterface;
    abstract public function get(string $id): NamedEntityInterface;
    abstract public function update(string $id, array $data): NamedEntityInterface;
    abstract public function delete(string $id): bool;
}
