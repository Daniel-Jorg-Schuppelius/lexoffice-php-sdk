<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : InvoicesEndpointTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Tests\Endpoints\Documents;

use Lexoffice\API\Endpoints\Documents\InvoicesEndpoint;
use Lexoffice\Entities\Documents\Invoices\Invoice;
use Lexoffice\Entities\Documents\Invoices\InvoiceResource;
use Tests\Contracts\EndpointTest;

class InvoicesEndpointTest extends EndpointTest {
    protected ?InvoicesEndpoint $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new InvoicesEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }

    public function testJsonSerialize() {
        $data = [
            "lineItems" => [
                [
                    "discountPercentage" => 50.0,
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
                        "taxRatePercentage" => 19.0
                    ],
                    "lineItemAmount" => 13.4
                ],
                [
                    "discountPercentage" => 0.0,
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
                        "taxRatePercentage" => 7.0
                    ],
                    "lineItemAmount" => 8.32
                ],
                [
                    "discountPercentage" => 0.0,
                    "type" => "custom",
                    "name" => "Energieriegel Testpaket",
                    "quantity" => 1.0,
                    "unitName" => "Stück",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 5.0,
                        "grossAmount" => 5.0,
                        "taxRatePercentage" => 0.0
                    ],
                    "lineItemAmount" => 5.0
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
                    "discountPercentage" => 3.0,
                    "discountRange" => 10
                ]
            ],
            "shippingConditions" => [
                "shippingDate" => "2023-04-22T00:00:00.000+02:00",
                "shippingType" => "delivery"
            ],
            "closingInvoice" => false,
            "id" => "e9066f04-8cc7-4616-93f8-ac9ecc8479c8",
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "createdDate" => "2023-04-24T08:20:22.528+02:00",
            "updatedDate" => "2023-04-24T08:20:22.528+02:00",
            "version" => 0,
            "language" => "de",
            "archived" => false,
            "voucherStatus" => "draft",
            "voucherNumber" => "RE1019",
            "voucherDate" => "2023-02-22T00:00:00.000+01:00",
            "address" => [
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
                "totalTaxAmount" => 3.13,
            ],
            "taxAmounts" => [
                [
                    "taxRatePercentage" => 0.0,
                    "taxAmount" => 0.0,
                    "netAmount" => 5.0
                ],
                [
                    "taxRatePercentage" => 7.0,
                    "taxAmount" => 0.58,
                    "netAmount" => 8.32
                ],
                [
                    "taxRatePercentage" => 19.0,
                    "taxAmount" => 2.55,
                    "netAmount" => 13.4
                ]
            ],
            "taxConditions" => [
                "taxType" => "net",
            ],
            "relatedVouchers" => [],
            "printLayoutId" => "28c212c4-b6dd-11ee-b80a-dbc65f4ceccf",
            "title" => "Rechnung",
            "introduction" => "Ihre bestellten Positionen stellen wir Ihnen hiermit in Rechnung",
            "remark" => "Vielen Dank für Ihren Einkauf",
            "files" => [
                "documentFileId" => "75295db7-7e69-4630-befd-a7f4ddfdaa83"
            ]
        ];

        $invoice = new Invoice($data, $this->logger);
        $this->assertEquals(json_encode($data), $invoice->toJson());
        $this->assertStringNotContainsString('lineItems":{"0":', $invoice->toJson());
        $this->assertStringContainsString(substr($invoice->getTitle(), 2, -2), $invoice->toJson());
    }

    public function testCreateAndGetInvoiceAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "archived" => false,
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
                    "name" => "Energieriegel Testpaket",
                    "quantity" => 1,
                    "unitName" => "Stück",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 5,
                        "taxRatePercentage" => 0
                    ],
                    "discountPercentage" => 0
                ],
                [
                    "type" => "text",
                    "name" => "Strukturieren Sie Ihre Belege durch Text-Elemente.",
                    "description" => "Das hilft beim Verständnis"
                ]
            ],
            "totalPrice" => [
                "currency" => "EUR"
            ],
            "taxConditions" => [
                "taxType" => "net"
            ],
            "paymentConditions" => [
                "paymentTermLabel" => "10 Tage - 3 %, 30 Tage netto",
                "paymentTermDuration" => 30,
                "paymentDiscountConditions" => [
                    "discountPercentage" => 3,
                    "discountRange" => 10
                ]
            ],
            "shippingConditions" => [
                "shippingDate" => "2023-04-22T00:00:00.000+02:00",
                "shippingType" => "delivery"
            ],
            "title" => "Rechnung",
            "introduction" => "Ihre bestellten Positionen stellen wir Ihnen hiermit in Rechnung",
            "remark" => "Vielen Dank für Ihren Einkauf"
        ];

        $invoice = new Invoice($data);
        $invoiceResource = $this->endpoint->create($invoice);
        $this->assertInstanceOf(InvoiceResource::class, $invoiceResource);
        $loadedInvoice = $this->endpoint->get($invoiceResource->getId());
        $this->assertInstanceOf(Invoice::class, $loadedInvoice);
        $this->assertEquals($invoice->getAddress(), $loadedInvoice->getAddress());
    }
}
