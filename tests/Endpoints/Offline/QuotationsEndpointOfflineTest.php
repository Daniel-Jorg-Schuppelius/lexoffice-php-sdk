<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : QuotationsEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\Documents\QuotationsEndpoint;
use Lexoffice\Entities\Documents\Quotations\Quotation;
use Lexoffice\Entities\Vouchers\VoucherID;
use Tests\Contracts\OfflineEndpointTest;

class QuotationsEndpointOfflineTest extends OfflineEndpointTest {
    private QuotationsEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new QuotationsEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'quotations/629c831d-c5e7-4ca5-8b94-ea3e3ba02fbd', 200, json_encode([
            'id' => '629c831d-c5e7-4ca5-8b94-ea3e3ba02fbd',
            'version' => 0,
            'voucherDate' => '2024-03-15',
            'expirationDate' => '2024-04-15',
            'address' => [
                'name' => 'Test Customer',
            ],
            'lineItems' => [
                [
                    'type' => 'custom',
                    'name' => 'Proposed Product',
                    'quantity' => 1,
                    'unitPrice' => [
                        'netAmount' => 200.00,
                        'taxRatePercentage' => 19,
                    ],
                ],
            ],
            'totalPrice' => [
                'totalNetAmount' => 200.00,
                'totalGrossAmount' => 238.00,
                'totalTaxAmount' => 38.00,
                'currency' => 'EUR',
            ],
            'taxConditions' => [
                'taxType' => 'net',
            ],
        ]));

        $this->mockClient->setDefaultResponse(200, json_encode([
            'id' => '629c831d-c5e7-4ca5-8b94-ea3e3ba02fbd',
            'version' => 0,
        ]));
    }

    public function test_get_quotation(): void {
        $id = new ID('629c831d-c5e7-4ca5-8b94-ea3e3ba02fbd');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(Quotation::class, $result);
        $this->assertEquals('2024-03-15', $result->getVoucherDate()->format('Y-m-d'));
        $this->assertRequestMade('GET', 'quotations/629c831d-c5e7-4ca5-8b94-ea3e3ba02fbd');
    }

    public function test_get_quotation_without_id_throws_exception(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function test_pursue_quotation_throws_not_allowed_exception(): void {
        $this->expectException(NotAllowedException::class);
        $this->expectExceptionMessage('Quotations cannot be pursued');

        $voucherId = new VoucherID('some-voucher-id');
        $this->endpoint->pursue($voucherId, false);
    }
}
