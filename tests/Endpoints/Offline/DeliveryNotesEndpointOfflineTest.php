<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DeliveryNotesEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\Documents\DeliveryNotesEndpoint;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNote;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNoteResource;
use Lexoffice\Entities\Vouchers\VoucherID;
use Tests\Contracts\OfflineEndpointTest;

class DeliveryNotesEndpointOfflineTest extends OfflineEndpointTest {
    private DeliveryNotesEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new DeliveryNotesEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('GET', 'delivery-notes/69b92f7d-8649-4a28-b749-f924d8fcccd2', 200, json_encode([
            'id' => '69b92f7d-8649-4a28-b749-f924d8fcccd2',
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
                ],
            ],
            'taxConditions' => [
                'taxType' => 'net',
            ],
        ]));

        $this->mockClient->addResponse('POST', 'delivery-notes*precedingSalesVoucherId*', 201, json_encode([
            'id' => 'new-delivery-note-id-12345',
            'resourceUri' => 'https://api.lexoffice.io/v1/delivery-notes/new-delivery-note-id-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));

        $this->mockClient->addResponse('POST', 'delivery-notes/69b92f7d-8649-4a28-b749-f924d8fcccd2/sendmail', 204, '');

        $this->mockClient->setDefaultResponse(200, json_encode([
            'id' => 'new-delivery-note-id-12345',
            'resourceUri' => 'https://api.lexoffice.io/v1/delivery-notes/new-delivery-note-id-12345',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));
    }

    public function testGetDeliveryNote(): void {
        $id = new ID('69b92f7d-8649-4a28-b749-f924d8fcccd2');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(DeliveryNote::class, $result);
        $this->assertEquals('2024-03-15', $result->getVoucherDate()->format('Y-m-d'));
        $this->assertRequestMade('GET', 'delivery-notes/69b92f7d-8649-4a28-b749-f924d8fcccd2');
    }

    public function testGetDeliveryNoteWithoutIdThrowsException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function testPursueDeliveryNote(): void {
        $voucherId = new VoucherID('previous-voucher-id-12345');
        $result = $this->endpoint->pursue($voucherId, false);

        $this->assertInstanceOf(DeliveryNoteResource::class, $result);
        $this->assertRequestMade('POST', 'delivery-notes*precedingSalesVoucherId*');
    }

    public function testSendMail(): void {
        $id = new ID('69b92f7d-8649-4a28-b749-f924d8fcccd2');
        $this->endpoint->sendMail($id, ['test@example.com'], 'Test message', 'Best regards');

        $this->assertRequestMade('POST', 'delivery-notes/69b92f7d-8649-4a28-b749-f924d8fcccd2/sendmail');
    }
}
