<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use Lexoffice\Contracts\Interfaces\API\ApiClientInterface;
use Lexoffice\Contracts\Interfaces\API\EndpointInterface;
use Lexoffice\Contracts\Interfaces\API\ResourceInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\ID;
use Lexoffice\Exceptions\ApiException;
use Psr\Http\Message\ResponseInterface;

abstract class EndpointAbstract implements EndpointInterface {
    protected ApiClientInterface $client;
    protected string $endpoint;

    public function __construct(ApiClientInterface $client) {
        $this->client = $client;
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

    abstract public function create(NamedEntityInterface $data): ResourceInterface;
    abstract public function get(ID $id): NamedEntityInterface;
    abstract public function update(ID $id, NamedEntityInterface $data): ResourceInterface;
    abstract public function delete(ID $id): bool;
}
