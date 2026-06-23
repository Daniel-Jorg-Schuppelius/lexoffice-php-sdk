<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ProfileEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Endpoints;

use APIToolkit\Contracts\Interfaces\API\EndpointInterface;
use Lexoffice\API\Endpoints\ProfileEndpoint;
use Lexoffice\Entities\Profile\Profile;
use Tests\Contracts\EndpointTest;

class ProfileEndpointTest extends EndpointTest {
    private ?EndpointInterface $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new ProfileEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }
    public function test_get_profile_api() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $profile = $this->endpoint->get();
        $this->assertInstanceOf(Profile::class, $profile);
    }
}
