<?php

declare(strict_types=1);

namespace Tests\Lexoffice\Entities;

use Lexoffice\Entities\VoucherList\Vouchers;
use PHPUnit\Framework\TestCase;

class VoucherListTest extends TestCase {
    public function testCreateVoucher() {
        $data = [
            "content" => [
                [
                    "id" => "57b8d457-1fb6-4ae9-944a-9fe763da2aff",
                    "voucherType" => "purchaseinvoice",
                    "voucherStatus" => "open",
                    "voucherNumber" => "2010096",
                    "voucherDate" => "2023-06-14T00:00:00.000+02:00",
                    "createdDate" => "2023-03-22T12:36:22.000+01:00",
                    "updatedDate" => "2023-03-22T12:36:22.000+01:00",
                    "dueDate" => "2023-06-21T00:00:00.000+02:00",
                    "contactId" => null,
                    "contactName" => "Sammellieferant",
                    "totalAmount" => 80.04,
                    "openAmount" => 80.04,
                    "currency" => "EUR",
                    "archived" => false
                ],
                [
                    "id" => "f3d3ae48-30d9-4b56-973a-b3159cbe743c",
                    "voucherType" => "invoice",
                    "voucherStatus" => "open",
                    "voucherNumber" => "RE1012",
                    "voucherDate" => "2023-05-14T00:00:00.000+02:00",
                    "createdDate" => "2023-05-14T16:52:21.000+02:00",
                    "updatedDate" => "2023-05-14T16:52:21.000+02:00",
                    "dueDate" => "2023-05-24T00:00:00.000+02:00",
                    "contactId" => "777c7793-9fbb-4ec7-9254-0619c199761e",
                    "contactName" => "Musterfrau, Erika",
                    "totalAmount" => 99.8,
                    "openAmount" => 74.8,
                    "currency" => "EUR",
                    "archived" => false
                ],
                [
                    "id" => "55aa6de8-d32d-47bd-9c3c-d541ab65a8e8",
                    "voucherType" => "invoice",
                    "voucherStatus" => "overdue",
                    "voucherNumber" => "RE1011",
                    "voucherDate" => "2023-03-02T00:00:00.000+01:00",
                    "createdDate" => "2023-03-03T16:52:21.000+01:00",
                    "updatedDate" => "2023-03-03T16:52:21.000+01:00",
                    "dueDate" => "2023-10-06T00:00:00.000+02:00",
                    "contactId" => "b08a1ac7-10fc-4214-b875-8491f91479dd",
                    "contactName" => "Test GmbH",
                    "totalAmount" => 498.8,
                    "openAmount" => 498.8,
                    "currency" => "EUR",
                    "archived" => false
                ]
            ],
        ];
        $vouchers = new Vouchers($data);
        $this->assertInstanceOf(Vouchers::class, $vouchers);
    }
}
