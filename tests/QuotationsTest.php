<?php

declare(strict_types=1);

namespace Tests\Lexoffice\Entities;

use Lexoffice\Entities\Documents\Quotations\Quotation;
use PHPUnit\Framework\TestCase;

class QuotationsTest extends TestCase {
    public function testCreateQuotations() {
        $data = [
            "id" => "424f784e-1f4e-439e-8f71-19673e6d6583",
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "createdDate" => "2023-03-16T12:43:16.689+01:00",
            "updatedDate" => "2023-03-16T15:26:30.074+01:00",
            "version" => 4,
            "language" => "de",
            "archived" => false,
            "voucherStatus" => "open",
            "voucherNumber" => "AG0006",
            "voucherDate" => "2023-03-16T12:43:03.900+01:00",
            "expirationDate" => "2023-04-15T12:43:03.900+02:00",
            "address" => [
                "contactId" => "97c5794f-8ab2-43ad-b459-c5980b055e4d",
                "name" => "Berliner Kindl GmbH",
                "street" => "Jubiläumsweg 25",
                "city" => "Berlin",
                "zip" => "14089",
                "countryCode" => "DE"
            ],
            "lineItems" => [
                [
                    "id" => "68569bfc-e5ae-472d-bbdf-6d51a82b1d2f",
                    "type" => "material",
                    "name" => "Axa Rahmenschloss Defender RL",
                    "description" => "Vollständig symmetrisches Design in metallicfarbener Ausführung. Der ergonomische Bedienkopf garantiert die große Benutzerfreundlichkeit dieses Schlosses. Sehr niedrige Kopfhöhe von 46 mm, also mehr Rahmenfreiheit...",
                    "quantity" => 1,
                    "unitName" => "Stück",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 20.08,
                        "grossAmount" => 23.9,
                        "taxRatePercentage" => 19
                    ],
                    "discountPercentage" => 0,
                    "lineItemAmount" => 23.90,
                    "subItems" => [
                        [
                            "id" => "97b98491-e953-4dc9-97a9-ae437a8052b4",
                            "type" => "material",
                            "name" => "Abus Kabelschloss Primo 590 ",
                            "description" => "· 9,5 mm starkes, smoke-mattes Spiralkabel mit integrierter Halterlösung zur Befestigung am Sattelklemmbolzen · bewährter Qualitäts-Schließzylinder mit praktischem Wendeschlüssel · KabelØ: 9,5 mm, Länge: 150 cm",
                            "quantity" => 1,
                            "unitName" => "Stück",
                            "unitPrice" => [
                                "currency" => "EUR",
                                "netAmount" => 13.4,
                                "grossAmount" => 15.95,
                                "taxRatePercentage" => 19
                            ],
                            "discountPercentage" => 0,
                            "lineItemAmount" => 15.95,
                            "alternative" => true,
                            "optional" => false
                        ]
                    ],
                    "alternative" => false,
                    "optional" => false
                ],
                [
                    "id" => "0722bcc6-d1b7-417b-b834-3b47794fa9ab",
                    "type" => "service",
                    "name" => "Einfache Montage",
                    "description" => "Aufwand für einfache Montagetätigkeit",
                    "quantity" => 1,
                    "unitName" => "Stunde",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 4.12,
                        "grossAmount" => 4.9,
                        "taxRatePercentage" => 19
                    ],
                    "discountPercentage" => 0,
                    "lineItemAmount" => 4.90,
                    "alternative" => false,
                    "optional" => true
                ]
            ],
            "totalPrice" => [
                "currency" => "EUR",
                "totalNetAmount" => 20.08,
                "totalGrossAmount" => 23.90,
                "totalTaxAmount" => 3.82
            ],
            "taxAmounts" => [
                [
                    "taxRatePercentage" => 19,
                    "taxAmount" => 3.82,
                    "netAmount" => 20.08
                ]
            ],
            "taxConditions" => [
                "taxType" => "gross"
            ],
            "paymentConditions" => [
                "paymentTermLabel" => "10 Tage - 3 %, 30 Tage netto",
                "paymentTermLabelTemplate" => "{discountRange} Tage -{discount}, {paymentRange} Tage netto",
                "paymentTermDuration" => 30,
                "paymentDiscountConditions" => [
                    "discountPercentage" => 3,
                    "discountRange" => 10
                ]
            ],
            "relatedVouchers" => [],
            "printLayoutId" => "28c212c4-b6dd-11ee-b80a-dbc65f4ceccf",
            "introduction" => "Gerne bieten wir Ihnen an:",
            "remark" => "Wir freuen uns auf Ihre Auftragserteilung und sichern eine einwandfreie Ausführung zu.",
            "files" => [
                "documentFileId" => "ebd84e8a-716d-4a20-a76d-21de75a6d3d1"
            ],
            "title" => "Angebot"
        ];

        $quotations = new Quotation($data);
        $this->assertInstanceOf(Quotation::class, $quotations);
    }
}
