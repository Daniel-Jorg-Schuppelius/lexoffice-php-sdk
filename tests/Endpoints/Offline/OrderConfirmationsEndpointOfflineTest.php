<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : OrderConfirmationsEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\Documents\OrderConfirmationsEndpoint;
use Lexoffice\Entities\Documents\OrderConfirmations\OrderConfirmation;
use Lexoffice\Entities\Documents\OrderConfirmations\OrderConfirmationResource;
use Lexoffice\Entities\Vouchers\VoucherID;
use Tests\Contracts\OfflineEndpointTest;

class OrderConfirmationsEndpointOfflineTest extends OfflineEndpointTest {
    private OrderConfirmationsEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new OrderConfirmationsEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'order-confirmations/abc12345-6789-0def-ghij-klmnopqrstuv', 200, json_encode([
            'id' => 'abc12345-6789-0def-ghij-klmnopqrstuv',
            'version' => 0,
            'voucherDate' => '2024-03-15',
            'address' => [
                'name' => 'Test Customer',
            ],
            'lineItems' => [
                [
                    'type' => 'custom',
                    'name' => 'Product',
                    'quantity' => 2,
                    'unitPrice' => [
                        'netAmount' => 50.00,
                        'taxRatePercentage' => 19,
                    ],
                ],
            ],
            'totalPrice' => [
                'totalNetAmount' => 100.00,
                'totalGrossAmount' => 119.00,
                'totalTaxAmount' => 19.00,
                'currency' => 'EUR',
            ],
            'taxConditions' => [
                'taxType' => 'net',
            ],
        ]));

        $this->mockClient->addResponse('POST', 'order-confirmations*precedingSalesVoucherId*', 201, json_encode([
            'id' => 'new-order-confirmation-id-12345',
            'resourceUri' => 'https://api.lexoffice.io/v1/order-confirmations/new-order-confirmation-id-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));

        $this->mockClient->setDefaultResponse(200, json_encode([
            'id' => 'new-order-confirmation-id-12345',
            'resourceUri' => 'https://api.lexoffice.io/v1/order-confirmations/new-order-confirmation-id-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));
    }

    public function testGetOrderConfirmation(): void {
        $id = new ID('abc12345-6789-0def-ghij-klmnopqrstuv');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(OrderConfirmation::class, $result);
        $this->assertEquals('2024-03-15', $result->getVoucherDate()->format('Y-m-d'));
        $this->assertRequestMade('GET', 'order-confirmations/abc12345-6789-0def-ghij-klmnopqrstuv');
    }

    public function testGetOrderConfirmationWithoutIdThrowsException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function testPursueOrderConfirmation(): void {
        $voucherId = new VoucherID('previous-quotation-id-12345');
        $result = $this->endpoint->pursue($voucherId, false);

        $this->assertInstanceOf(OrderConfirmationResource::class, $result);
        $this->assertRequestMade('POST', 'order-confirmations*precedingSalesVoucherId*');
    }
}
