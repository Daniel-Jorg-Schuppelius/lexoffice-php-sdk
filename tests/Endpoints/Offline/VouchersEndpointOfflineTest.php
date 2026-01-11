<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VouchersEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\VouchersEndpoint;
use Lexoffice\Entities\Vouchers\Voucher;
use Lexoffice\Entities\Vouchers\VoucherResource;
use Lexoffice\Entities\Vouchers\VouchersPage;
use Tests\Contracts\OfflineEndpointTest;

class VouchersEndpointOfflineTest extends OfflineEndpointTest {
    private VouchersEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new VouchersEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('POST', 'vouchers', 200, json_encode([
            'id' => 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            'resourceUri' => 'https://api.lexoffice.io/v1/vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));

        $this->mockClient->addResponse('GET', 'vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890', 200, json_encode([
            'id' => 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            'version' => 0,
            'voucherNumber' => 'RE-2024-001',
            'voucherDate' => '2024-03-15',
            'voucherType' => 'invoice',
            'voucherStatus' => 'open',
            'totalGrossAmount' => 119.00,
            'totalTaxAmount' => 19.00,
        ]));

        $this->mockClient->addResponse('GET', 'vouchers', 200, json_encode([
            'content' => [],
            'first' => true,
            'last' => true,
            'totalPages' => 0,
            'totalElements' => 0,
            'numberOfElements' => 0,
            'size' => 25,
            'number' => 0,
            'sort' => [],
        ]));
    }

    public function testCreateVoucher(): void {
        $data = [
            'version' => 0,
            'voucherNumber' => 'RE-2024-001',
            'voucherDate' => '2024-03-15',
            'voucherType' => 'invoice',
            'totalGrossAmount' => 119.00,
            'totalTaxAmount' => 19.00,
        ];

        $voucher = new Voucher($data);
        $result = $this->endpoint->create($voucher);

        $this->assertInstanceOf(VoucherResource::class, $result);
        $this->assertEquals('a1b2c3d4-e5f6-7890-abcd-ef1234567890', $result->getId()->toString());
        $this->assertRequestMade('POST', 'vouchers');
    }

    public function testGetVoucher(): void {
        $id = new ID('a1b2c3d4-e5f6-7890-abcd-ef1234567890');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(Voucher::class, $result);
        $this->assertEquals('RE-2024-001', $result->getVoucherNumber());
        $this->assertRequestMade('GET', 'vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890');
    }

    public function testGetVoucherWithoutIdThrowsException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function testUpdateVoucher(): void {
        $this->mockClient->addResponse('PUT', 'vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890', 200, json_encode([
            'id' => 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            'resourceUri' => 'https://api.lexoffice.io/v1/vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T11:00:00.000+01:00',
            'version' => 1,
        ]));

        $id = new ID('a1b2c3d4-e5f6-7890-abcd-ef1234567890');
        $voucher = new Voucher([
            'version' => 0,
            'voucherNumber' => 'RE-2024-001-UPDATED',
        ]);

        $result = $this->endpoint->update($id, $voucher);

        $this->assertInstanceOf(VoucherResource::class, $result);
        $this->assertRequestMade('PUT', 'vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890');
    }

    public function testDeleteVoucherThrowsNotAllowedException(): void {
        $this->expectException(NotAllowedException::class);
        $this->expectExceptionMessage('Vouchers cannot be deleted');

        $id = new ID('a1b2c3d4-e5f6-7890-abcd-ef1234567890');
        $this->endpoint->delete($id);
    }

    public function testSearchVouchersWithVoucherNumber(): void {
        $result = $this->endpoint->search(['voucherNumber' => 'RE-2024-001']);

        $this->assertInstanceOf(VouchersPage::class, $result);
        $this->assertRequestMade('GET', 'vouchers*');
    }

    public function testSearchVouchersWithoutVoucherNumberThrowsException(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('voucherNumber is required');

        $this->endpoint->search([]);
    }
}
