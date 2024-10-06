<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VouchersTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Entities;

use Lexoffice\Entities\Vouchers\Voucher;
use PHPUnit\Framework\TestCase;

class VouchersTest extends TestCase {
    public function testCreateVoucher() {
        $data = [
            "id" => "a8691b5d-2393-4317-888d-bcd5d564f7d1",
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "type" => "salesinvoice",
            "voucherStatus" => "open",
            "voucherNumber" => "2023-000321",
            "voucherDate" => "2023-06-30T00:00:00.000+02:00",
            "shippingDate" => "2023-07-02T00:00:00.000+02:00",
            "dueDate" => "2023-07-07T00:00:00.000+02:00",
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
            "createdDate" => "2023-06-30T13:28:51.012+02:00",
            "updatedDate" => "2023-06-30T13:28:51.012+02:00",
            "version" => 2
        ];

        $voucher = new Voucher($data);
        $this->assertInstanceOf(Voucher::class, $voucher);
    }
}
