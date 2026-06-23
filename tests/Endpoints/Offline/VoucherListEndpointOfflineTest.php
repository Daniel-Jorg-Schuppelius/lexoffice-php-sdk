<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VoucherListEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use InvalidArgumentException;
use Lexoffice\API\Endpoints\VoucherListEndpoint;
use Lexoffice\Entities\VoucherList\{VoucherListPage, Vouchers};
use Tests\Contracts\OfflineEndpointTest;

class VoucherListEndpointOfflineTest extends OfflineEndpointTest {
    private VoucherListEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new VoucherListEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        // Use wildcard to match query parameters (e.g., voucherlist?voucherType=invoice&voucherStatus=open)
        $this->mockClient->addResponse('GET', 'voucherlist*', 200, json_encode([
            'content' => [
                [
                    'id' => 'voucher-12345',
                    'voucherType' => 'invoice',
                    'voucherStatus' => 'open',
                    'voucherNumber' => 'RE-2024-001',
                    'voucherDate' => '2024-03-15',
                    'createdDate' => '2024-03-15T10:30:00.000+01:00',
                    'updatedDate' => '2024-03-15T10:30:00.000+01:00',
                    'contactName' => 'Test Customer',
                    'totalAmount' => 119.00,
                    'currency' => 'EUR',
                ],
            ],
            'first' => true,
            'last' => true,
            'totalPages' => 1,
            'totalElements' => 1,
            'numberOfElements' => 1,
            'size' => 25,
            'number' => 0,
            'sort' => [],
        ]));
    }

    public function test_search_voucher_list(): void {
        $result = $this->endpoint->search([
            'voucherType' => 'invoice',
            'voucherStatus' => 'open',
        ]);

        $this->assertInstanceOf(VoucherListPage::class, $result);
        $this->assertRequestMade('GET', 'voucherlist*');
    }

    public function test_search_voucher_list_without_voucher_type_throws_exception(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('voucherType is required');

        $this->endpoint->search(['voucherStatus' => 'open']);
    }

    public function test_search_voucher_list_without_voucher_status_throws_exception(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('voucherStatus is required');

        $this->endpoint->search(['voucherType' => 'invoice']);
    }

    public function test_get_voucher_list_returns_vouchers(): void {
        $result = $this->endpoint->get();

        $this->assertInstanceOf(Vouchers::class, $result);
        $this->assertRequestMade('GET', 'voucherlist*');
    }
}
