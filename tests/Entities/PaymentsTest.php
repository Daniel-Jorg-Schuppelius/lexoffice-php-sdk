<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : PaymentsTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Entities;

use Lexoffice\Entities\Payments\Payment;
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

        $payment1 = new Payment($data1);
        $this->assertInstanceOf(Payment::class, $payment1);
        $payment2 = new Payment($data2);
        $this->assertInstanceOf(Payment::class, $payment2);
        $payment3 = new Payment($data3);
        $this->assertInstanceOf(Payment::class, $payment3);
        $payment4 = new Payment($data4);
        $this->assertInstanceOf(Payment::class, $payment4);
        $payments1 = new Payments([$payment1->toArray(), $payment2->toArray(), $payment3->toArray(), $payment4->toArray()]);
        $this->assertInstanceOf(Payments::class, $payments1);
        $this->assertCount(4, $payments1->getValues());
        $this->assertEquals($payment1, $payments1->getValues()[0]);
        $this->assertEquals($payment2, $payments1->getValues()[1]);
        $this->assertEquals($payment3, $payments1->getValues()[2]);
        $this->assertEquals($payment4, $payments1->getValues()[3]);
        $payments2 = new Payments([$payment1, $payment2, $payment3, $payment4]);
        $this->assertInstanceOf(Payments::class, $payments2);
        $this->assertCount(4, $payments2->getValues());
        $this->assertEquals($payments1, $payments2);
    }
}
