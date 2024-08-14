<?php

namespace Tests\Endpoints;

use Lexoffice\Api\Endpoints\CountriesEndpoint;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\Countries\Countries;
use Tests\Contracts\EndpointTest;

class CountriesEndpointTest extends EndpointTest {
    private ?ListableEndpointInterface $endpoint;

    private bool $apiDisabled = true;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new CountriesEndpoint($this->client);
    }

    public function testGetCountriesAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $countries = $this->endpoint->list();
        $this->assertInstanceOf(Countries::class, $countries);
    }
}
