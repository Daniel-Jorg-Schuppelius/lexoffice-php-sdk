<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DownPaymentInvoicesEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\Documents\DownPaymentInvoicesEndpoint;
use Lexoffice\Entities\Documents\DownPaymentInvoices\DownPaymentInvoice;
use Tests\Contracts\OfflineEndpointTest;

class DownPaymentInvoicesEndpointOfflineTest extends OfflineEndpointTest {
    private DownPaymentInvoicesEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new DownPaymentInvoicesEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'down-payment-invoices/d52370ee-5bf5-11eb-ac18-17b8d0fb237f', 200, json_encode([
            'id' => 'd52370ee-5bf5-11eb-ac18-17b8d0fb237f',
            'version' => 0,
            'voucherDate' => '2024-03-15',
            'address' => [
                'name' => 'Test Customer',
            ],
            'lineItems' => [
                [
                    'type' => 'custom',
                    'name' => 'Down Payment',
                    'quantity' => 1,
                    'unitPrice' => [
                        'netAmount' => 500.00,
                        'taxRatePercentage' => 19,
                    ],
                ],
            ],
            'totalPrice' => [
                'totalNetAmount' => 500.00,
                'totalGrossAmount' => 595.00,
                'totalTaxAmount' => 95.00,
                'currency' => 'EUR',
            ],
            'taxConditions' => [
                'taxType' => 'net',
            ],
        ]));

        $this->mockClient->setDefaultResponse(200, json_encode([
            'id' => 'd52370ee-5bf5-11eb-ac18-17b8d0fb237f',
            'version' => 0,
        ]));
    }

    public function test_get_down_payment_invoice(): void {
        $id = new ID('d52370ee-5bf5-11eb-ac18-17b8d0fb237f');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(DownPaymentInvoice::class, $result);
        $this->assertEquals('2024-03-15', $result->getVoucherDate()->format('Y-m-d'));
        $this->assertRequestMade('GET', 'down-payment-invoices/d52370ee-5bf5-11eb-ac18-17b8d0fb237f');
    }

    public function test_get_down_payment_invoice_without_id_throws_exception(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }
}
