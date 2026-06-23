<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DunningsEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\Documents\DunningsEndpoint;
use Lexoffice\Entities\Documents\Dunnings\{Dunning, DunningResource};
use Lexoffice\Entities\Vouchers\VoucherID;
use Tests\Contracts\OfflineEndpointTest;

class DunningsEndpointOfflineTest extends OfflineEndpointTest {
    private DunningsEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new DunningsEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'dunnings/5d217758-ea2a-11eb-a8d0-47ec974ddbcf', 200, json_encode([
            'id' => '5d217758-ea2a-11eb-a8d0-47ec974ddbcf',
            'version' => 0,
            'voucherDate' => '2024-03-15',
            'address' => [
                'name' => 'Test Customer',
            ],
            'lineItems' => [
                [
                    'type' => 'custom',
                    'name' => 'Overdue Invoice',
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

        $this->mockClient->addResponse('POST', 'dunnings*precedingSalesVoucherId*', 201, json_encode([
            'id' => 'new-dunning-id-12345',
            'resourceUri' => 'https://api.lexoffice.io/v1/dunnings/new-dunning-id-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));

        $this->mockClient->setDefaultResponse(200, json_encode([
            'id' => 'new-dunning-id-12345',
            'resourceUri' => 'https://api.lexoffice.io/v1/dunnings/new-dunning-id-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));
    }

    public function test_get_dunning(): void {
        $id = new ID('5d217758-ea2a-11eb-a8d0-47ec974ddbcf');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(Dunning::class, $result);
        $this->assertEquals('2024-03-15', $result->getVoucherDate()->format('Y-m-d'));
        $this->assertRequestMade('GET', 'dunnings/5d217758-ea2a-11eb-a8d0-47ec974ddbcf');
    }

    public function test_get_dunning_without_id_throws_exception(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function test_pursue_dunning(): void {
        $voucherId = new VoucherID('previous-invoice-id-12345');
        $result = $this->endpoint->pursue($voucherId, false);

        $this->assertInstanceOf(DunningResource::class, $result);
        $this->assertRequestMade('POST', 'dunnings*precedingSalesVoucherId*');
    }
}
