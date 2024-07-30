<?php

namespace Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use Lexoffice\API\Client;
use Lexoffice\Api\Endpoints\CountriesEndpoint;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\Countries\Countries;
use Lexoffice\Logger\ConsoleLogger;
use Tests\Config\PostmanConfig;

class CountriesEndpointTest extends TestCase {
    private ?Client $client;
    private ?ListableEndpointInterface $endpoint;
    private ?PostmanConfig $config;
    private ?ConsoleLogger $logger = null;

    private bool $apiDisabled = true;

    public function __construct($name) {
        parent::__construct($name);
        $this->config = new PostmanConfig();
        //$this->logger = new ConsoleLogger();
        $this->client = new Client($this->config->accessToken, $this->config->resourceUrl . '/v1/', $this->logger, true);
        $this->endpoint = new CountriesEndpoint($this->client);
    }

    protected function setUp(): void {
        if (!$this->apiDisabled && $this->config->isConfigured()) {
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

    public function testGetCountriesAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $countries = $this->endpoint->list();
        $this->assertInstanceOf(Countries::class, $countries);
    }
}
