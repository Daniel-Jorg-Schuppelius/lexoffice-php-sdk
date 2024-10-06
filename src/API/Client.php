<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Client.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API;

use APIToolkit\Contracts\Interfaces\API\ApiClientInterface;
use Lexoffice\Exceptions\ApiException;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client as HttpClient;
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

class Client implements ApiClientInterface {
    public const MIN_INTERVAL = 0.5;
    private bool $sleepAfterRequest;
    private float $lastRequestTime = 0.0;
    private float $requestInterval = 0.65;

    private HttpClient $client;
    private ?LoggerInterface $logger;

    public function __construct(?string $apiKey, string $baseUrl = 'https://api.lexoffice.io/v1/', ?LoggerInterface $logger = null, bool $sleepAfterRequest = false) {
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
            usleep((int)(($this->requestInterval - $timeSinceLastRequest) * 1e6));
        }

        if ($this->logger) {
            $this->logger->info("Sending {$method} request to {$uri} (waiting {$microsecondsToSleep} microseconds to execute)", $options);
        }

        $options['http_errors'] = false;
        $this->lastRequestTime = microtime(true);
        $response = $this->client->request($method, $uri, $options);
        if ($this->sleepAfterRequest) {
            // Sleep for 0.5 seconds after each request to avoid rate limiting
            usleep((int)(Client::MIN_INTERVAL * 1e6));
        }

        if ($response->getStatusCode() >= 400) {
            switch ($response->getStatusCode()) {
                case 400:
                    throw new BadRequestException('Bad Request', 400, $response);
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
                    throw new ApiException('Unexpected response status code', $response->getStatusCode(), $response);
                    break;
            }
        }

        return $response;
    }
}
