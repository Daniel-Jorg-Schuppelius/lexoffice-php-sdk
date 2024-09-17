<?php

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\VoucherListEndpoint;
use APIToolkit\Contracts\Interfaces\API\EndpointInterface;
use Lexoffice\Entities\VoucherList\Vouchers;
use Tests\Contracts\EndpointTest;

class VoucherListEndpointTest extends EndpointTest {
    private ?EndpointInterface $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new VoucherListEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }
    public function testGetVoucherListAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $voucherList = $this->endpoint->get();
        $this->assertInstanceOf(Vouchers::class, $voucherList);
    }
}
