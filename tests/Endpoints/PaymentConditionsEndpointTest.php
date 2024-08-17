<?php

namespace Tests\Endpoints;

use Lexoffice\Api\Endpoints\PaymentConditionsEndpoint;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PaymentConditions\PaymentConditions;
use Tests\Contracts\EndpointTest;

class PaymentConditionsEndpointTest extends EndpointTest {
    private ?ListableEndpointInterface $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new PaymentConditionsEndpoint($this->client);
        $this->apiDisabled = false; // API is disabled
    }

    public function testGetPaymentConditionsAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $paymentConditions = $this->endpoint->list();
        $this->assertInstanceOf(PaymentConditions::class, $paymentConditions);
    }
}
