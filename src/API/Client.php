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

use APIToolkit\API\Authentication\BearerAuthentication;
use APIToolkit\Contracts\Abstracts\API\ClientAbstract;
use Psr\Log\LoggerInterface;

class Client extends ClientAbstract {
    public const MIN_INTERVAL = 0.5;
    protected float $requestInterval = 0.65;
    protected float $timeout = 2.0;

    public function __construct(?string $apiKey, string $baseUrl = 'https://api.lexoffice.io/v1/', ?LoggerInterface $logger = null, bool $sleepAfterRequest = false) {
        parent::__construct($baseUrl, $logger, $sleepAfterRequest);

        $this->setDefaultHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        if ($apiKey !== null) {
            $this->setAuthentication(new BearerAuthentication($apiKey));
        }
    }
}
