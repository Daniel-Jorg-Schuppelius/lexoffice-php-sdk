<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PrintLayoutsEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\PrintLayoutsEndpoint;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PrintLayouts\PrintLayouts;
use Tests\Contracts\EndpointTest;

class PrintLayoutsEndpointTest extends EndpointTest {
    private ListableEndpointInterface $endpoint;

    protected function setUp(): void {
        $this->apiDisabled = true; // API is disabled
        parent::setUp();
        $this->endpoint = new PrintLayoutsEndpoint($this->client);
    }

    public function test_get_posting_categories_api(): void {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $printLayouts = $this->endpoint->list();
        $this->assertInstanceOf(PrintLayouts::class, $printLayouts);
    }
}
