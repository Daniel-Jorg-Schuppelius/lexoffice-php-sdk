<?php

declare(strict_types=1);

namespace Tests\Entities;

use Lexoffice\Entities\Payments\Payments;
use PHPUnit\Framework\TestCase;

class PaymentsTest extends TestCase {
    public function testCreatePayments() {
        $data1 = [
            "openAmount" => 200.00,
            "currency" => "EUR",
            "paymentStatus" => "openRevenue",
            "voucherType" => "invoice",
            "voucherStatus" => "open",
            "paymentItems" => []
        ];

        $data2 = [
            "openAmount" => 39.90,
            "paymentStatus" => "openExpense",
            "currency" => "EUR",
            "voucherType" => "purchaseinvoice",
            "voucherStatus" => "open",
            "paymentItems" => [
                [
                    "paymentItemType" => "manualPayment",
                    "postingDate" => "2023-11-07T00:00:00.000+01:00",
                    "amount" => 10.50,
                    "currency" => "EUR"
                ],
                [
                    "paymentItemType" => "manualPayment",
                    "postingDate" => "2023-11-13T00:00:00.000+01:00",
                    "amount" => 20.0,
                    "currency" => "EUR"
                ]
            ]
        ];

        $data3 = [
            "openAmount" => 0.0,
            "currency" => "EUR",
            "paymentStatus" => "balanced",
            "voucherType" => "purchasecreditnote",
            "voucherStatus" => "paidoff",
            "paidDate" => "2023-07-14T13:42:02.123+02:00",
            "paymentItems" => [
                [
                    "paymentItemType" => "manualPayment",
                    "postingDate" => "2023-07-14T00:00:00.000+01:00",
                    "amount" => 119.0,
                    "currency" => "EUR"
                ]
            ]
        ];

        $data4 = [
            "openAmount" => 0.0,
            "paymentStatus" => "balanced",
            "currency" => "EUR",
            "voucherType" => "invoice",
            "voucherStatus" => "paid",
            "paidDate" => "2023-07-14T13:42:02.123+02:00",
            "paymentItems" => [
                [
                    "paymentItemType" => "manualPayment",
                    "postingDate" => "2023-07-14T00:00:00.000+01:00",
                    "amount" => 72.0,
                    "currency" => "EUR"
                ],
                [
                    "paymentItemType" => "cashDiscount",
                    "postingDate" => "2023-07-14T00:00:00.000+01:00",
                    "amount" => 7.85,
                    "currency" => "EUR"
                ]
            ]
        ];
        $payments1 = new Payments($data1);
        $this->assertInstanceOf(Payments::class, $payments1);
        $payments2 = new Payments($data2);
        $this->assertInstanceOf(Payments::class, $payments2);
        $payments3 = new Payments($data3);
        $this->assertInstanceOf(Payments::class, $payments3);
        $payments4 = new Payments($data4);
        $this->assertInstanceOf(Payments::class, $payments4);
    }
}
