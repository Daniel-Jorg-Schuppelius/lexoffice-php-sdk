<?php

namespace Tests\Endpoints\Documents;

use Lexoffice\Api\Endpoints\Documents\RecurringTemplatesEndpoint;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplate;
use Lexoffice\Entities\Documents\RecurringTemplates\RecurringTemplatesPage;
use Tests\Contracts\EndpointTest;

class RecurringTemplatesEndpointTest extends EndpointTest {
    protected ?RecurringTemplatesEndpoint $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new RecurringTemplatesEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }

    public function testJsonSerialize() {
        $data = [
            "lineItems" => [
                [
                    "discountPercentage" => 50,
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
                    "lineItemAmount" => 13.4
                ],
                [
                    "discountPercentage" => 0,
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
                    "lineItemAmount" => 8.32
                ],
                [
                    "discountPercentage" => 0,
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
                ],
                [
                    "type" => "text",
                    "name" => "Freitextposition",
                    "description" => "This item type can contain either a name or a description or both."
                ]
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
            "recurringTemplateSettings" => [
                "id" => "9c5b8bde-7d36-49e8-af5c-4fbe7dc9fa01",
                "startDate" => "2023-03-01",
                "nextExecutionDate" => "2023-03-01",
                "endDate" => "2023-06-30",
                "finalize" => true,
                "shippingType" => "service",
                "executionInterval" => "MONTHLY",
                "lastExecutionFailed" => false,
                "executionStatus" => "ACTIVE"
            ],
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
                "zip" => "79112",
                "city" => "Freiburg",
                "countryCode" => "DE"
            ],
            "totalPrice" => [
                "currency" => "EUR",
                "totalNetAmount" => 26.72,
                "totalGrossAmount" => 29.85,
                "totalTaxAmount" => 3.13
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
                "taxType" => "net"
            ],
            "title" => "Rechnung",
            "introduction" => "Ihre bestellten Positionen stellen wir Ihnen hiermit in Rechnung",
            "remark" => "Vielen Dank für Ihren Einkauf"
        ];


        $recurringTemplate = new RecurringTemplate($data, $this->logger);
        $this->assertEquals(json_encode($data), $recurringTemplate->toJson());
        $this->assertStringNotContainsString('lineItems":{"0":', $recurringTemplate->toJson());
        $this->assertStringContainsString(substr($recurringTemplate->getTitle(), 2, -2), $recurringTemplate->toJson());
    }

    public function testGetRecurringTemplatesPage() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $recurringTemplatePage = $this->endpoint->search();
        $this->assertNotEmpty($recurringTemplatePage);
        $this->assertInstanceOf(RecurringTemplatesPage::class, $recurringTemplatePage);
    }
}
