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

use APIToolkit\Contracts\Abstracts\API\ClientAbstract;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

class Client extends ClientAbstract {
    public const MIN_INTERVAL = 0.5;
    protected float $requestInterval = 0.65;

    public function __construct(?string $apiKey, string $baseUrl = 'https://api.lexoffice.io/v1/', ?LoggerInterface $logger = null, bool $sleepAfterRequest = false) {
        parent::__construct(new HttpClient([
            'base_uri' => $baseUrl,
            'timeout' => 2.0,
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]), $logger, $sleepAfterRequest);
    }

    protected function requestWithRetry(string $method, string $uri, array $options = [], int $maxRetries = 3, int $retryDelay = 1): ResponseInterface {
        return parent::requestWithRetry($method, $uri, $options, $maxRetries, $retryDelay);
    }
}
