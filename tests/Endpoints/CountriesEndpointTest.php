<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : CountriesEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\CountriesEndpoint;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\Countries\Countries;
use Tests\Contracts\EndpointTest;

class CountriesEndpointTest extends EndpointTest {
    private ListableEndpointInterface $endpoint;

    protected function setUp(): void {
        $this->apiDisabled = true; // API is disabled
        parent::setUp();
        $this->endpoint = new CountriesEndpoint($this->client);
    }

    public function test_get_countries_api(): void {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $countries = $this->endpoint->list();
        $this->assertInstanceOf(Countries::class, $countries);
    }
}
