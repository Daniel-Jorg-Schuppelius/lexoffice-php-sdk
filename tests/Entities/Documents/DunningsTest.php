<?php

declare(strict_types=1);

namespace Tests\Entities\Documents;

use Lexoffice\Entities\Documents\Dunnings\Dunning;
use PHPUnit\Framework\TestCase;

class DunningsTest extends TestCase {
    public function testCreateDunning() {
        $data = [
            "id" => "e9066f04-8cc7-4616-93f8-ac9ecc8479c8",
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "createdDate" => "2023-07-17T18:32:07.480+02:00",
            "updatedDate" => "2023-07-17T18:32:07.551+02:00",
            "version" => 1,
            "language" => "de",
            "archived" => false,
            "voucherStatus" => "draft",
            "voucherDate" => "2023-07-17T00:00:00.000+02:00",
            "address" => [
                "supplement" => "Gebäude 10",
                "street" => "Musterstraße 42",
                "city" => "Freiburg",
                "zip" => "79112",
                "countryCode" => "DE"
            ],
            "lineItems" => [
                [
                    "type" => "custom",
                    "name" => "Energieriegel Testpaket",
                    "quantity" => 1,
                    "unitName" => "Stück",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 5,
                        "grossAmount" => 5.0,
                        "taxRatePercentage" => 0.0
                    ],
                    "discountPercentage" => 0,
                    "lineItemAmount" => 5.0
                ],
                [
                    "type" => "text",
                    "name" => "Strukturieren Sie Ihre Belege durch Text-Elemente.",
                    "description" => "Das hilft beim Verständnis"
                ]
            ],
            "totalPrice" => [
                "currency" => "EUR",
                "totalNetAmount" => 5.0,
                "totalGrossAmount" => 5.0,
                "totalTaxAmount" => 0.0
            ],
            "taxAmounts" => [
                [
                    "taxRatePercentage" => 0.0,
                    "taxAmount" => 0.0,
                    "netAmount" => 5.0
                ]
            ],
            "taxConditions" => [
                "taxType" => "net"
            ],
            "shippingConditions" => [
                "shippingDate" => "2023-07-21T15:16:44.051+02:00",
                "shippingType" => "delivery"
            ],
            "relatedVouchers" => [
                [
                    "id" => "52cd26a2-ea26-11eb-a4f0-2bb179f80c5a",
                    "voucherNumber" => "RE0357",
                    "voucherType" => "invoice"
                ]
            ],
            "printLayoutId" => "28c212c4-b6dd-11ee-b80a-dbc65f4ceccf",
            "introduction" => "Wir bitten Sie, die nachfolgend aufgelisteten Lieferungen/Leistungen unverzüglich zu begleichen.",
            "remark" => "Sollten Sie den offenen Betrag bereits beglichen haben, betrachten Sie dieses Schreiben als gegenstandslos.",
            "files" => [
                "documentFileId" => "4e19354c-ea26-11eb-a31f-af2d58e85357"
            ],
            "title" => "Mahnung"
        ];

        $dunnings = new Dunning($data);
        $this->assertInstanceOf(Dunning::class, $dunnings);
    }
}
