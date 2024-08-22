<?php

namespace Tests\Endpoints;

use Lexoffice\Api\Endpoints\VoucherListEndpoint;
use Lexoffice\Contracts\Interfaces\API\BaseEndpointInterface;
use Lexoffice\Entities\VoucherList\Vouchers;
use Tests\Contracts\EndpointTest;

class VoucherListEndpointTest extends EndpointTest {
    private ?BaseEndpointInterface $endpoint;

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
