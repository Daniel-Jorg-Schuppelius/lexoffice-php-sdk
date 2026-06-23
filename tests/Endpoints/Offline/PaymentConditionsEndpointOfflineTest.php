<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentConditionsEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Exceptions\NotAllowedException;
use Lexoffice\API\Endpoints\PaymentConditionsEndpoint;
use Lexoffice\Entities\PaymentConditions\PaymentConditions;
use Tests\Contracts\OfflineEndpointTest;

class PaymentConditionsEndpointOfflineTest extends OfflineEndpointTest {
    private PaymentConditionsEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new PaymentConditionsEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'payment-conditions', 200, json_encode([
            [
                'id' => 'cond-12345',
                'organizationDefault' => true,
                'paymentTermLabelTemplate' => 'Zahlbar innerhalb von {paymentTermDuration} Tagen',
                'paymentTermDuration' => 14,
                'paymentDiscountConditions' => null,
            ],
            [
                'id' => 'cond-67890',
                'organizationDefault' => false,
                'paymentTermLabelTemplate' => 'Zahlbar sofort',
                'paymentTermDuration' => 0,
                'paymentDiscountConditions' => null,
            ],
        ]));
    }

    public function test_list_payment_conditions(): void {
        $result = $this->endpoint->list();

        $this->assertInstanceOf(PaymentConditions::class, $result);
        $this->assertRequestMade('GET', 'payment-conditions');
    }

    public function test_get_payment_condition_throws_not_allowed_exception(): void {
        $this->expectException(NotAllowedException::class);
        $this->expectExceptionMessage('Getting a single payment condition is not allowed');

        $this->endpoint->get(null);
    }
}
