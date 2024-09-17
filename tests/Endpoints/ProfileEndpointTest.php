<?php

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\ProfileEndpoint;
use APIToolkit\Contracts\Interfaces\API\EndpointInterface;
use Lexoffice\Entities\Profile\Profile;
use Tests\Contracts\EndpointTest;

class ProfileEndpointTest extends EndpointTest {
    private ?EndpointInterface $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new ProfileEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }
    public function testGetProfileAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $profile = $this->endpoint->get();
        $this->assertInstanceOf(Profile::class, $profile);
    }
}
