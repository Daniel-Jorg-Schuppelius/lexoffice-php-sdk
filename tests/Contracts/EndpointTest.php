<?php

declare(strict_types=1);

namespace Tests\Contracts;

use PHPUnit\Framework\TestCase;
use Lexoffice\API\Client;
use Lexoffice\Contracts\Interfaces\API\EndpointInterface;
use Lexoffice\Logger\ConsoleLoggerFactory;
use Psr\Log\LoggerInterface;
use Tests\TestAPIClientFactory;

abstract class EndpointTest extends TestCase {
    protected ?LoggerInterface $logger = null;

    protected ?Client $client;

    protected bool $apiDisabled = false;

    public function __construct($name) {
        parent::__construct($name);
        $this->logger = ConsoleLoggerFactory::getLogger();
        $this->client = TestAPIClientFactory::getClient();
    }

    final protected function setUp(): void {
        if (!$this->apiDisabled && !is_null($this->client)) {
            try {
                $response = $this->client->get("ping");
                $this->apiDisabled = $response->getStatusCode() != 200;
            } catch (\Exception $e) {
                $this->apiDisabled = true;
            }
        } else {
            $this->apiDisabled = true;
        }
    }
}
