<?php

declare(strict_types=1);

namespace Tests\Lexoffice\Entities;

use Lexoffice\Entities\Document\CreditNotes\CreditNotes;
use PHPUnit\Framework\TestCase;

class CreditNotesTest extends TestCase {
    public function testCreateCreditNotes() {
        $data = [
            "id" => "e9066f04-8cc7-4616-93f8-ac9ecc8479c8",
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "createdDate" => "2023-06-17T18:32:07.480+02:00",
            "updatedDate" => "2023-06-17T18:32:07.551+02:00",
            "version" => 1,
            "language" => "de",
            "archived" => false,
            "voucherStatus" => "draft",
            "voucherNumber" => "GS0007",
            "voucherDate" => "2023-02-22T00:00:00.000+01:00",
            "address" => [
                "name" => "Bike & Ride GmbH & Co. KG",
                "supplement" => "Gebäude 10",
                "street" => "Musterstraße 42",
                "city" => "Freiburg",
                "zip" => "79112",
                "countryCode" => "DE"
            ],
            "lineItems" => [
                [
                    "type" => "custom",
                    "name" => "Abus Kabelschloss Primo 590",
                    "description" => "· 9,5 mm starkes, smoke-mattes Spiralkabel mit integrierter Halterlösung zur Befestigung am Sattelklemmbolzen · bewährter Qualitäts-Schließzylinder mit praktischem Wendeschlüssel · KabelØ: 9,5 mm, Länge: 150 cm",
                    "quantity" => 2,
                    "unitName" => "Stück",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 13.4,
                        "grossAmount" => 15.946,
                        "taxRatePercentage" => 19
                    ],
                    "lineItemAmount" => 26.8
                ],
                [
                    "type" => "custom",
                    "name" => "Energieriegel Testpaket",
                    "quantity" => 1,
                    "unitName" => "Stück",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 5,
                        "grossAmount" => 5,
                        "taxRatePercentage" => 0
                    ],
                    "lineItemAmount" => 5
                ]
            ],
            "totalPrice" => [
                "currency" => "EUR",
                "totalNetAmount" => 31.8,
                "totalGrossAmount" => 36.89,
                "totalTaxAmount" => 5.09
            ],
            "taxAmounts" => [
                [
                    "taxRatePercentage" => 0,
                    "taxAmount" => 0,
                    "netAmount" => 5
                ],
                [
                    "taxRatePercentage" => 19,
                    "taxAmount" => 5.09,
                    "netAmount" => 26.8
                ]
            ],
            "taxConditions" => [
                "taxType" => "net"
            ],
            "relatedVouchers" => [],
            "printLayoutId" => "28c212c4-b6dd-11ee-b80a-dbc65f4ceccf",
            "title" => "Rechnungskorrektur",
            "introduction" => "Rechnungskorrektur zur Rechnung RE-00020",
            "remark" => "Folgende Lieferungen/Leistungen schreiben wir Ihnen gut.",
            "files" => [
                "documentFileId" => "a79fea19-a892-4ea9-89ad-e879946329a3"
            ]
        ];

        $creditNotes = new CreditNotes($data);
        $this->assertInstanceOf(CreditNotes::class, $creditNotes);
        //$this->assertEquals('Lexware buchhaltung Premium 2024', $creditNotes->title);
        //$this->assertTrue($article->archived);
        //$this->assertIsArray($company->contactPersons);
        //$this->assertInstanceOf(ContactPerson::class, $company->contactPersons[0]);
    }
}
