<?php

declare(strict_types=1);

namespace Tests\Lexoffice\Entities;

use Lexoffice\Entities\PaymentConditions\PaymentConditions;
use PHPUnit\Framework\TestCase;

class PaymentConditionsTest extends TestCase {
    public function testCreatePaymentConditions() {
        $data = [
            [
                "id" => "65be0654-60b6-11eb-b66d-5731dbc9bf6b",
                "paymentTermLabelTemplate" => "Zahlbar in {paymentRange} Tagen, rein netto ohne Abzug",
                "paymentTermDuration" => 14,
                "organizationDefault" => false
            ],
            [
                "id" => "3fcc62d1-0925-456d-890b-779b56e7289e",
                "paymentTermLabelTemplate" => "10 Tage - 3 %, 30 Tage netto",
                "paymentTermDuration" => 30,
                "paymentDiscountConditions" => [
                    "discountRange" => 10,
                    "discountPercentage" => 3.00
                ],
                "organizationDefault" => true
            ]
        ];

        $paymentConditions = new PaymentConditions($data);
        $this->assertInstanceOf(PaymentConditions::class, $paymentConditions);
        //$this->assertEquals('Lexware buchhaltung Premium 2024', $payments->title);
        //$this->assertTrue($article->archived);
        //$this->assertIsArray($company->contactPersons);
        //$this->assertInstanceOf(ContactPerson::class, $company->contactPersons[0]);
    }
}
