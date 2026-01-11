<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : CreditNotesEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\Documents\CreditNotesEndpoint;
use Lexoffice\Entities\Documents\CreditNotes\CreditNote;
use Lexoffice\Entities\Documents\CreditNotes\CreditNoteResource;
use Lexoffice\Entities\Vouchers\VoucherID;
use Tests\Contracts\OfflineEndpointTest;

class CreditNotesEndpointOfflineTest extends OfflineEndpointTest {
    private CreditNotesEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new CreditNotesEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'credit-notes/854af5e4-323f-4fd1-b51e-0f83cdd98bcf', 200, json_encode([
            'id' => '854af5e4-323f-4fd1-b51e-0f83cdd98bcf',
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

        $this->mockClient->addResponse('POST', 'credit-notes*precedingSalesVoucherId*', 201, json_encode([
            'id' => 'new-credit-note-id-12345',
            'resourceUri' => 'https://api.lexoffice.io/v1/credit-notes/new-credit-note-id-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));

        $this->mockClient->setDefaultResponse(200, json_encode([
            'id' => 'new-credit-note-id-12345',
            'resourceUri' => 'https://api.lexoffice.io/v1/credit-notes/new-credit-note-id-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));
    }

    public function testGetCreditNote(): void {
        $id = new ID('854af5e4-323f-4fd1-b51e-0f83cdd98bcf');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(CreditNote::class, $result);
        $this->assertEquals('2024-03-15', $result->getVoucherDate()->format('Y-m-d'));
        $this->assertRequestMade('GET', 'credit-notes/854af5e4-323f-4fd1-b51e-0f83cdd98bcf');
    }

    public function testGetCreditNoteWithoutIdThrowsException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function testPursueCreditNote(): void {
        $voucherId = new VoucherID('previous-voucher-id-12345');
        $result = $this->endpoint->pursue($voucherId, false);

        $this->assertInstanceOf(CreditNoteResource::class, $result);
        $this->assertRequestMade('POST', 'credit-notes*precedingSalesVoucherId*');
    }
}
