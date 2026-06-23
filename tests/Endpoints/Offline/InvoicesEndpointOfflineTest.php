<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : InvoicesEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\Documents\InvoicesEndpoint;
use Lexoffice\Entities\Documents\Invoices\{Invoice, InvoiceResource};
use Lexoffice\Entities\Vouchers\VoucherID;
use Tests\Contracts\OfflineEndpointTest;

class InvoicesEndpointOfflineTest extends OfflineEndpointTest {
    private InvoicesEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new InvoicesEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'invoices/f4d3c2b1-a0e9-8765-4321-fedcba098765', 200, json_encode([
            'id' => 'f4d3c2b1-a0e9-8765-4321-fedcba098765',
            'version' => 0,
            'voucherDate' => '2024-03-15',
            'address' => [
                'name' => 'Test Customer',
            ],
            'lineItems' => [
                [
                    'type' => 'custom',
                    'name' => 'Test Item',
                    'quantity' => 1,
                    'unitPrice' => [
                        'netAmount' => 100.00,
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

        // Response for pursue (POST with status 201)
        $this->mockClient->addResponse('POST', 'invoices*precedingSalesVoucherId*', 201, json_encode([
            'id' => 'new-invoice-id-12345',
            'resourceUri' => 'https://api.lexoffice.io/v1/invoices/new-invoice-id-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));

        $this->mockClient->setDefaultResponse(200, json_encode([
            'id' => 'new-invoice-id-12345',
            'resourceUri' => 'https://api.lexoffice.io/v1/invoices/new-invoice-id-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));
    }

    public function test_get_invoice(): void {
        $id = new ID('f4d3c2b1-a0e9-8765-4321-fedcba098765');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(Invoice::class, $result);
        $this->assertEquals('2024-03-15', $result->getVoucherDate()->format('Y-m-d'));
        $this->assertRequestMade('GET', 'invoices/f4d3c2b1-a0e9-8765-4321-fedcba098765');
    }

    public function test_get_invoice_without_id_throws_exception(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function test_pursue_invoice(): void {
        $voucherId = new VoucherID('previous-voucher-id-12345');
        $result = $this->endpoint->pursue($voucherId, false);

        $this->assertInstanceOf(InvoiceResource::class, $result);
        $this->assertRequestMade('POST', 'invoices*precedingSalesVoucherId*');
    }
}
