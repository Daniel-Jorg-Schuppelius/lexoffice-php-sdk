<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : OrderConfirmationsTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Entities\Documents;

use Lexoffice\Entities\Documents\OrderConfirmations\OrderConfirmation;
use PHPUnit\Framework\TestCase;

class OrderConfirmationsTest extends TestCase {
    public function testCreateOrderConfirmation() {
        $data = [
            "id" => "e9066f04-8cc7-4616-93f8-ac9ecc8479c8",
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "createdDate" => "2023-04-24T08:20:22.528+02:00",
            "updatedDate" => "2023-04-24T08:20:22.528+02:00",
            "version" => 0,
            "language" => "de",
            "archived" => false,
            "voucherStatus" => "draft",
            "voucherNumber" => "AB1019",
            "voucherDate" => "2023-02-22T00:00:00.000+01:00",
            "address" => [
                "contactId" => null,
                "name" => "Bike & Ride GmbH & Co. KG",
                "supplement" => "Gebäude 10",
                "street" => "Musterstraße 42",
                "city" => "Freiburg",
                "zip" => "79112",
                "countryCode" => "DE"
            ],
            "lineItems" => [
                [
                    "id" => "97b98491-e953-4dc9-97a9-ae437a8052b4",
                    "type" => "material",
                    "name" => "Abus Kabelschloss Primo 590 ",
                    "description" => "· 9,5 mm starkes, smoke-mattes Spiralkabel mit integrierter Halterlösung zur Befestigung am Sattelklemmbolzen · bewährter Qualitäts-Schließzylinder mit praktischem Wendeschlüssel · KabelØ: 9,5 mm, Länge: 150 cm",
                    "quantity" => 2,
                    "unitName" => "Stück",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 13.4,
                        "grossAmount" => 15.95,
                        "taxRatePercentage" => 19
                    ],
                    "discountPercentage" => 50,
                    "lineItemAmount" => 13.4
                ],
                [
                    "id" => "dc4c805b-7df1-4310-a548-22be4499eb04",
                    "type" => "service",
                    "name" => "Aufwändige Montage",
                    "description" => "Aufwand für arbeitsintensive Montagetätigkeit",
                    "quantity" => 1,
                    "unitName" => "Stunde",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 8.32,
                        "grossAmount" => 8.9,
                        "taxRatePercentage" => 7
                    ],
                    "discountPercentage" => 0,
                    "lineItemAmount" => 8.32
                ],
                [
                    "id" => null,
                    "type" => "custom",
                    "name" => "Energieriegel Testpaket",
                    "description" => null,
                    "quantity" => 1,
                    "unitName" => "Stück",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 5,
                        "grossAmount" => 5,
                        "taxRatePercentage" => 0
                    ],
                    "discountPercentage" => 0,
                    "lineItemAmount" => 5
                ],
                [
                    "type" => "text",
                    "name" => "Freitextposition",
                    "description" => "This item type can contain either a name or a description or both."
                ]
            ],
            "totalPrice" => [
                "currency" => "EUR",
                "totalNetAmount" => 26.72,
                "totalGrossAmount" => 29.85,
                "totalTaxAmount" => 3.13,
                "totalDiscountAbsolute" => null,
                "totalDiscountPercentage" => null
            ],
            "taxAmounts" => [
                [
                    "taxRatePercentage" => 0,
                    "taxAmount" => 0,
                    "netAmount" => 5
                ],
                [
                    "taxRatePercentage" => 7,
                    "taxAmount" => 0.58,
                    "netAmount" => 8.32
                ],
                [
                    "taxRatePercentage" => 19,
                    "taxAmount" => 2.55,
                    "netAmount" => 13.4
                ]
            ],
            "taxConditions" => [
                "taxType" => "net",
                "taxTypeNote" => null
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
            "shippingConditions" => [
                "shippingDate" => "2023-04-22T00:00:00.000+02:00",
                "shippingEndDate" => null,
                "shippingType" => "delivery"
            ],
            "relatedVouchers" => [],
            "printLayoutId" => "28c212c4-b6dd-11ee-b80a-dbc65f4ceccf",
            "title" => "Auftragsbestätigung",
            "introduction" => "Ihre bestellten Positionen stellen wir Ihnen hiermit in Rechnung",
            "remark" => "Vielen Dank für Ihren Einkauf",
            "deliveryTerms" => "Lieferung an die angegebene Lieferadresse"
        ];

        $orderConfirmations = new OrderConfirmation($data);
        $this->assertInstanceOf(OrderConfirmation::class, $orderConfirmations);
    }
}
