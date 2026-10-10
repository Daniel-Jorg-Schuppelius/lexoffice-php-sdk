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
use Lexoffice\Entities\Files\{File, FileResource};
use Lexoffice\Entities\Vouchers\{Voucher, VoucherResource, VouchersPage};
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
        ], JSON_THROW_ON_ERROR));

        $this->mockClient->addResponse('GET', 'vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890', 200, json_encode([
            'id' => 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            'version' => 0,
            'voucherNumber' => 'RE-2024-001',
            'voucherDate' => '2024-03-15',
            'voucherType' => 'invoice',
            'voucherStatus' => 'open',
            'totalGrossAmount' => 119.00,
            'totalTaxAmount' => 19.00,
        ], JSON_THROW_ON_ERROR));

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
        ], JSON_THROW_ON_ERROR));
    }

    public function test_create_voucher(): void {
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

    public function test_get_voucher(): void {
        $id = new ID('a1b2c3d4-e5f6-7890-abcd-ef1234567890');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(Voucher::class, $result);
        $this->assertEquals('RE-2024-001', $result->getVoucherNumber());
        $this->assertRequestMade('GET', 'vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890');
    }

    public function test_get_voucher_without_id_throws_exception(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function test_update_voucher(): void {
        $this->mockClient->addResponse('PUT', 'vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890', 200, json_encode([
            'id' => 'a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            'resourceUri' => 'https://api.lexoffice.io/v1/vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T11:00:00.000+01:00',
            'version' => 1,
        ], JSON_THROW_ON_ERROR));

        $id = new ID('a1b2c3d4-e5f6-7890-abcd-ef1234567890');
        $voucher = new Voucher([
            'version' => 0,
            'voucherNumber' => 'RE-2024-001-UPDATED',
        ]);

        $result = $this->endpoint->update($id, $voucher);

        $this->assertInstanceOf(VoucherResource::class, $result);
        $this->assertRequestMade('PUT', 'vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890');
    }

    public function test_delete_voucher_throws_not_allowed_exception(): void {
        $this->expectException(NotAllowedException::class);
        $this->expectExceptionMessage('Vouchers cannot be deleted');

        $id = new ID('a1b2c3d4-e5f6-7890-abcd-ef1234567890');
        $this->endpoint->delete($id);
    }

    public function test_search_vouchers_with_voucher_number(): void {
        $result = $this->endpoint->search(['voucherNumber' => 'RE-2024-001']);

        $this->assertInstanceOf(VouchersPage::class, $result);
        $this->assertRequestMade('GET', 'vouchers*');
    }

    public function test_search_vouchers_without_voucher_number_throws_exception(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('voucherNumber is required');

        $this->endpoint->search([]);
    }

    public function test_create_accepts_201_created(): void {
        $this->mockClient->clearResponses();
        $this->mockClient->addResponse('POST', 'vouchers', 201, json_encode([
            'id' => '66196c43-baf3-4335-bfee-d610367059db',
            'resourceUri' => 'https://api.lexware.io/v1/vouchers/66196c43-baf3-4335-bfee-d610367059db',
            'createdDate' => '2026-10-10T15:15:09.447+02:00',
            'updatedDate' => '2026-10-10T15:15:09.447+02:00',
            'version' => 1,
        ], JSON_THROW_ON_ERROR));

        $result = $this->endpoint->create(Voucher::fromArray([
            'type' => 'purchaseinvoice',
            'voucherStatus' => 'unchecked',
            'taxType' => 'gross',
            'useCollectiveContact' => true,
            'contactName' => 'Muster GmbH',
        ]));

        $this->assertSame('66196c43-baf3-4335-bfee-d610367059db', $result->getId()->toString());
    }

    public function test_add_file_posts_to_the_voucher_files_subresource(): void {
        $this->mockClient->addResponse('POST', 'vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890/files', 202, json_encode([
            'id' => '8118c402-1c70-4da1-a9f1-a22f480cc623',
        ], JSON_THROW_ON_ERROR));
        $path = tempnam(sys_get_temp_dir(), 'lexoffice-voucher') . '.pdf';
        file_put_contents($path, '%PDF-1.4 test');

        try {
            $result = $this->endpoint->addFile(new ID('a1b2c3d4-e5f6-7890-abcd-ef1234567890'), new File(['filePath' => $path]));
        } finally {
            @unlink($path);
        }

        $this->assertInstanceOf(FileResource::class, $result);
        $this->assertSame('8118c402-1c70-4da1-a9f1-a22f480cc623', $result->getId()->toString());
        $this->assertNull($result->getVoucherId());
        $this->assertRequestMade('POST', 'vouchers/a1b2c3d4-e5f6-7890-abcd-ef1234567890/files');
    }

    public function test_add_file_throws_for_missing_file(): void {
        $this->expectException(InvalidArgumentException::class);

        $this->endpoint->addFile(new ID('a1b2c3d4-e5f6-7890-abcd-ef1234567890'), new File(['filePath' => '/does/not/exist.pdf']));
    }
}
