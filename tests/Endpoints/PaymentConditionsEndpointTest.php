<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentConditionsEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Endpoints;

use Lexoffice\API\Endpoints\PaymentConditionsEndpoint;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PaymentConditions\PaymentConditions;
use Tests\Contracts\EndpointTest;

class PaymentConditionsEndpointTest extends EndpointTest {
    private ?ListableEndpointInterface $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new PaymentConditionsEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }

    public function testGetPaymentConditionsAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $paymentConditions = $this->endpoint->list();
        $this->assertInstanceOf(PaymentConditions::class, $paymentConditions);
    }
}
