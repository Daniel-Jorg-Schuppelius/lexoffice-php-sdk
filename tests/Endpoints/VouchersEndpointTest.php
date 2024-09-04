<?php

namespace Tests\Endpoints;

use Lexoffice\Api\Endpoints\VouchersEndpoint;
use Lexoffice\Entities\Vouchers\Voucher;
use Lexoffice\Entities\Vouchers\VoucherResource;
use Lexoffice\Entities\Vouchers\VouchersPage;
use Tests\Contracts\EndpointTest;

class VouchersEndpointTest extends EndpointTest {
    protected ?VouchersEndpoint $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new VouchersEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }

    public function testJsonSerialize() {
        $data = [
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "type" => "salesinvoice",
            "shippingDate" => "2023-07-02T00:00:00.000+02:00",
            "totalGrossAmount" => 326.00,
            "totalTaxAmount" => 26.00,
            "taxType" => "gross",
            "useCollectiveContact" => true,
            "remark" => "Bestellung von Max Mustermann.",
            "voucherItems" => [
                [
                    "amount" => 119.00,
                    "taxAmount" => 19.00,
                    "taxRatePercent" => 19.00,
                    "categoryId" => "8f8664a8-fd86-11e1-a21f-0800200c9a66"
                ],
                [
                    "amount" => 107.00,
                    "taxAmount" => 7.00,
                    "taxRatePercent" => 7.00,
                    "categoryId" => "8f8664a8-fd86-11e1-a21f-0800200c9a66"
                ],
                [
                    "amount" => 100.00,
                    "taxAmount" => 0,
                    "taxRatePercent" => 0.00,
                    "categoryId" => "8f8664a8-fd86-11e1-a21f-0800200c9a66"
                ]
            ],
            "files" => [],
            "version" => 2,
            "id" => "a8691b5d-2393-4317-888d-bcd5d564f7d1",
            "voucherStatus" => "open",
            "voucherNumber" => "2023-000321",
            "voucherDate" => "2023-06-30T00:00:00.000+02:00",
            "dueDate" => "2023-07-07T00:00:00.000+02:00",
            "createdDate" => "2023-06-30T13:28:51.012+02:00",
            "updatedDate" => "2023-06-30T13:28:51.012+02:00"
        ];

        $voucher = new Voucher($data);
        $this->assertEquals($data, $voucher->toArray());
        $this->assertEquals(json_encode($data), $voucher->toJson());  // the order of the $data array is important for this test.
        $this->assertStringContainsString(substr($voucher->getID()->toJson(), 2, -2), json_encode($data));
        $this->assertEquals(json_encode($data["voucherItems"]), $voucher->getVoucherItems()->toJson(0));
    }

    public function testCreateAndDeleteVoucherAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "type" => "salesinvoice",
            "voucherNumber" => "123-456",
            "voucherDate" => "2023-06-28",
            "shippingDate" => "2023-07-02",
            "dueDate" => "2023-07-05",
            "totalGrossAmount" => 119.00,
            "totalTaxAmount" => 19.00,
            "taxType" => "gross",
            "useCollectiveContact" => true,
            "remark" => "Bestellung von Max Mustermann.",
            "voucherItems" => [
                [
                    "amount" => 119.00,
                    "taxAmount" => 19.00,
                    "taxRatePercent" => 19,
                    "categoryId" => "8f8664a8-fd86-11e1-a21f-0800200c9a66"
                ]
            ]
        ];

        $voucher = new Voucher($data);
        $voucherResource = $this->endpoint->create($voucher);
        $this->assertInstanceOf(VoucherResource::class, $voucherResource);
    }

    public function testCreateGetUpdateAndDeleteVoucherAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "type" => "salesinvoice",
            "voucherNumber" => "123-456",
            "voucherDate" => "2023-06-28",
            "shippingDate" => "2023-07-02",
            "dueDate" => "2023-07-05",
            "totalGrossAmount" => 119.00,
            "totalTaxAmount" => 19.00,
            "taxType" => "gross",
            "useCollectiveContact" => true,
            "remark" => "Bestellung von Max Mustermann.",
            "voucherItems" => [
                [
                    "amount" => 119.00,
                    "taxAmount" => 19.00,
                    "taxRatePercent" => 19,
                    "categoryId" => "8f8664a8-fd86-11e1-a21f-0800200c9a66"
                ]
            ]
        ];

        $voucherResource = $this->endpoint->create(new Voucher($data));
        $this->assertInstanceOf(VoucherResource::class, $voucherResource);
        $voucher = $this->endpoint->get($voucherResource->getId());

        $voucher->remark = "Bestellung von Max Mustermann.";
        $voucherResourceUpdated = $this->endpoint->update($voucherResource->getId(), $voucher);
        $this->assertInstanceOf(VoucherResource::class, $voucherResourceUpdated);
    }

    public function testCreateSearchAndDeleteVoucherAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "type" => "salesinvoice",
            "voucherNumber" => "123-456",
            "voucherDate" => "2023-06-28",
            "shippingDate" => "2023-07-02",
            "dueDate" => "2023-07-05",
            "totalGrossAmount" => 119.00,
            "totalTaxAmount" => 19.00,
            "taxType" => "gross",
            "useCollectiveContact" => true,
            "remark" => "Bestellung von Max Mustermann.",
            "voucherItems" => [
                [
                    "amount" => 119.00,
                    "taxAmount" => 19.00,
                    "taxRatePercent" => 19,
                    "categoryId" => "8f8664a8-fd86-11e1-a21f-0800200c9a66"
                ]
            ]
        ];

        $vouchersPage = $this->endpoint->search(["voucherNumber" => "123-456"]);
        $this->assertInstanceOf(VouchersPage::class, $vouchersPage);

        $voucherResource = $this->endpoint->create(new Voucher($data));
        $this->assertInstanceOf(VoucherResource::class, $voucherResource);

        $vouchersPageUpdated = $this->endpoint->search(["voucherNumber" => "123-456"]);
        $this->assertInstanceOf(VouchersPage::class, $vouchersPageUpdated);
        $this->assertGreaterThan($vouchersPage->getTotalElements(), $vouchersPageUpdated->getTotalElements());
    }
}