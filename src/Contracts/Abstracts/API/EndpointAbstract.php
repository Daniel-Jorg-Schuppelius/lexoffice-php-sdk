<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use Lexoffice\Contracts\Interfaces\API\ApiClientInterface;
use Lexoffice\Contracts\Interfaces\API\EndpointInterface;
use Lexoffice\Contracts\Interfaces\API\ResourceInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\ID;
use Lexoffice\Exceptions\ApiException;
use Lexoffice\Exceptions\BadRequestException;
use Lexoffice\Exceptions\ConflictException;
use Lexoffice\Exceptions\ForbiddenException;
use Lexoffice\Exceptions\NotAcceptableException;
use Lexoffice\Exceptions\NotAllowedException;
use Lexoffice\Exceptions\NotFoundException;
use Lexoffice\Exceptions\PaymentRequiredException;
use Lexoffice\Exceptions\TooManyRequestsException;
use Lexoffice\Exceptions\UnauthorizedException;
use Lexoffice\Exceptions\UnsupportedMediaTypeException;
use Psr\Http\Message\ResponseInterface;

abstract class EndpointAbstract implements EndpointInterface {
    protected ApiClientInterface $client;
    protected string $endpoint;

    public function __construct(ApiClientInterface $client) {
        $this->client = $client;
    }

    protected function handleResponse(ResponseInterface $response, int $expectedStatusCode): string {
        $statusCode = $response->getStatusCode();

        switch ($statusCode) {
            case 400:
                throw new BadRequestException('Bad Rquest', 400, $response);
            case 401:
                throw new UnauthorizedException('Unauthorized', 401, $response);
            case 402:
                throw new PaymentRequiredException('Payment Required', 402, $response);
            case 403:
                throw new ForbiddenException('Forbidden', 403, $response);
            case 404:
                throw new NotFoundException('Resource not found', 404, $response);
            case 405:
                throw new NotAllowedException('Not Allowed', 405, $response);
            case 406:
                throw new NotAcceptableException('Not Acceptable', 406, $response);
            case 409:
                throw new ConflictException('Conflict', 409, $response);
            case 415:
                throw new UnsupportedMediaTypeException('Unsupported Media Type', 415, $response);
            case 429:
                throw new TooManyRequestsException('Too Many Requests! Set a higher value for Client->requestInterval', 429, $response);
            default:
                if ($statusCode !== $expectedStatusCode) {
                    throw new ApiException('Unexpected response status code', $statusCode, $response);
                }
                break;
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
