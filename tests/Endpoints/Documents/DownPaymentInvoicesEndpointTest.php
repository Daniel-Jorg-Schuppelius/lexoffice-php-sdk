<?php

namespace Tests\Endpoints\Documents;

use Lexoffice\API\Endpoints\Documents\DownPaymentInvoicesEndpoint;
use Lexoffice\Entities\Documents\DownPaymentInvoices\DownPaymentInvoice;
use Tests\Contracts\EndpointTest;

final class DownPaymentInvoicesEndpointTest extends EndpointTest {
    protected ?DownPaymentInvoicesEndpoint $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new DownPaymentInvoicesEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }

    public function testJsonSerialize() {
        $data = [
            "lineItems" => [
                [
                    "type" => "custom",
                    "name" => "Pauschaler Abschlag",
                    "quantity" => 1,
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 559.66,
                        "grossAmount" => 666,
                        "taxRatePercentage" => 19
                    ],
                    "lineItemAmount" => 666.00
                ]
            ],
            "shippingConditions" => [
                "shippingType" => "none"
            ],
            "id" => "0333f0c7-2b89-4889-b64e-68b3ca3f167a",
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "createdDate" => "2023-01-20T10:26:40.956+01:00",
            "updatedDate" => "2023-01-21T13:34:13.228+01:00",
            "version" => 3,
            "language" => "de",
            "archived" => false,
            "voucherStatus" => "open",
            "voucherNumber" => "RE1129",
            "voucherDate" => "2023-01-20T10:26:26.565+01:00",
            "dueDate" => "2023-02-19T00:00:00.000+01:00",
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
                "totalNetAmount" => 559.66,
                "totalGrossAmount" => 666.00,
                "totalTaxAmount" => 106.34
            ],
            "taxAmounts" => [
                [
                    "taxRatePercentage" => 19,
                    "taxAmount" => 106.34,
                    "netAmount" => 559.66
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
            "closingInvoiceId" => null,
            "relatedVouchers" => [],
            "printLayoutId" => "28c212c4-b6dd-11ee-b80a-dbc65f4ceccf",
            "introduction" => "Wie vereinbart, erlauben wir uns folgenden pauschalen Abschlag in Rechnung zu stellen.",
            "remark" => "Vielen Dank für die gute Zusammenarbeit.",
            "files" => [
                "documentFileId" => "aa0388c5-20b5-49d7-96ce-0c08ac0482f4"
            ],
            "title" => "1. Abschlagsrechnung"
        ];

        $downPaymentInvoice = new DownPaymentInvoice($data, $this->logger);
        $this->assertTrue($downPaymentInvoice->isValid());
        $this->assertNotEquals(json_encode($data), $downPaymentInvoice->toJson());
        $this->assertStringNotContainsString('lineItems":{"0":', $downPaymentInvoice->toJson());
        $this->assertStringContainsString(substr($downPaymentInvoice->getTitle(), 2, -2), $downPaymentInvoice->toJson());
    }
}
