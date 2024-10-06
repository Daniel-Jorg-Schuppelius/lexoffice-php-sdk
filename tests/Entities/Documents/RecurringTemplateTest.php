<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : RecurringTemplateTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Entities\Documents;

use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplate;
use PHPUnit\Framework\TestCase;

class RecurringTemplateTest extends TestCase {
    public function testCreateRecurringTemplate() {
        $data = [
            "id" => "ac1d66a8-6d59-408b-9413-d56b1db7946f",
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "createdDate" => "2023-02-10T09:00:00.000+01:00",
            "updatedDate" => "2023-02-10T09:00:00.000+01:00",
            "version" => 0,
            "language" => "de",
            "archived" => false,
            "address" => [
                "contactId" => "464f4881-7a8c-4dc4-87de-7c6fd9a506b8",
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
            "title" => "Rechnung",
            "introduction" => "Ihre bestellten Positionen stellen wir Ihnen hiermit in Rechnung",
            "remark" => "Vielen Dank für Ihren Einkauf",
            "recurringTemplateSettings" => [
                "id" => "9c5b8bde-7d36-49e8-af5c-4fbe7dc9fa01",
                "startDate" => "2023-03-01",
                "endDate" => "2023-06-30",
                "finalize" => true,
                "shippingType" => "service",
                "executionInterval" => "MONTHLY",
                "nextExecutionDate" => "2023-03-01",
                "lastExecutionFailed" => false,
                "lastExecutionErrorMessage" => null,
                "executionStatus" => "ACTIVE"
            ]
        ];
        $recurringTemplate = new RecurringTemplate($data);
        $this->assertInstanceOf(RecurringTemplate::class, $recurringTemplate);
    }
}
