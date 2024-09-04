<?php

namespace Tests\Endpoints\Documents;

use Lexoffice\Api\Endpoints\Documents\DeliveryNotesEndpoint;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNote;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNoteResource;
use Tests\Contracts\EndpointTest;

final class DeliveryNotesEndpointTest extends EndpointTest {
    protected ?DeliveryNotesEndpoint $endpoint;

    public function __construct($name) {
        parent::__construct($name);
        $this->endpoint = new DeliveryNotesEndpoint($this->client);
        $this->apiDisabled = true; // API is disabled
    }

    public function testJsonSerialize() {
        $data = [
            "lineItems" => [
                [
                    "type" => "custom",
                    "name" => "Abus Kabelschloss Primo 590 ",
                    "description" => "· 9,5 mm starkes, smoke-mattes Spiralkabel mit integrierter Halterlösung zur Befestigung am Sattelklemmbolzen · bewährter Qualitäts-Schließzylinder mit praktischem Wendeschlüssel · KabelØ: 9,5 mm, Länge: 150 cm",
                    "quantity" => 2,
                    "unitName" => "Stück",
                    "unitPrice" => [
                        "currency" => "EUR",
                        "netAmount" => 13.4,
                        "grossAmount" => 15.946,
                        "taxRatePercentage" => 19
                    ]
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
                    ]
                ]
            ],
            "id" => "e9066f04-8cc7-4616-93f8-ac9ecc8479c8",
            "organizationId" => "aa93e8a8-2aa3-470b-b914-caad8a255dd8",
            "createdDate" => "2023-06-17T18:32:07.480+02:00",
            "updatedDate" => "2023-06-17T18:32:07.551+02:00",
            "version" => 1,
            "language" => "de",
            "archived" => false,
            "voucherStatus" => "draft",
            "voucherNumber" => "LS0007",
            "voucherDate" => "2023-02-22T00:00:00.000+01:00",
            "address" => [
                "name" => "Bike & Ride GmbH & Co. KG",
                "supplement" => "Gebäude 10",
                "street" => "Musterstraße 42",
                "zip" => "79112",
                "city" => "Freiburg",
                "countryCode" => "DE"
            ],
            "taxConditions" => [
                "taxType" => "net"
            ],
            "relatedVouchers" => [],
            "printLayoutId" => "28c212c4-b6dd-11ee-b80a-dbc65f4ceccf",
            "title" => "Lieferschein",
            "introduction" => "Lieferschein zur Rechnung RE-00020",
            "remark" => "Folgende Lieferungen/Leistungen schreiben wir Ihnen gut.",
            "files" => [
                "documentFileId" => "a79fea19-a892-4ea9-89ad-e879946329a3"
            ]
        ];

        $deliveryNote = new DeliveryNote($data, $this->logger);
        $this->assertTrue($deliveryNote->isValid());
        $this->assertNotEquals(json_encode($data), $deliveryNote->toJson());
        $this->assertStringNotContainsString('lineItems":{"0":', $deliveryNote->toJson());
        $this->assertStringContainsString(substr($deliveryNote->getTitle(), 2, -2), $deliveryNote->toJson());
    }

    public function testCreateAndGetDeliveryNoteAPI() {
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
                    "name" => "Abus Kabelschloss Primo 590 ",
                    "description" => "· 9,5 mm starkes, smoke-mattes Spiralkabel mit integrierter Halterlösung zur Befestigung am Sattelklemmbolzen · bewährter Qualitäts-Schließzylinder mit praktischem Wendeschlüssel · KabelØ: 9,5 mm, Länge: 150 cm",
                    "quantity" => 2,
                    "unitName" => "Stück",
                    "unitPrice" => null
                ],
                [
                    "type" => "custom",
                    "name" => "Energieriegel Testpaket",
                    "quantity" => 1,
                    "unitName" => "Stück",
                    "unitPrice" => null
                ],
                [
                    "type" => "text",
                    "name" => "Strukturieren Sie Ihre Belege durch Text-Elemente.",
                    "description" => "Das hilft beim Verständnis"
                ]
            ],
            "taxConditions" => [
                "taxType" => "net"
            ],
            "shippingConditions" => [
                "shippingDate" => "2023-02-22T00:00:00.000+01:00",
                "shippingType" => "delivery"
            ],
            "title" => "Lieferschein",
            "introduction" => "Lieferschein zur Rechnung RE-00020",
            "deliveryTerms" => "Lieferung frei Haus.",
            "remark" => "Folgende Lieferungen/Leistungen schreiben wir Ihnen gut."
        ];

        $deliveryNote = new DeliveryNote($data);
        $deliveryNoteResource = $this->endpoint->create($deliveryNote);
        $this->assertInstanceOf(DeliveryNoteResource::class, $deliveryNoteResource);
        $loadedDeliveryNote = $this->endpoint->get($deliveryNoteResource->getId());
        $this->assertInstanceOf(DeliveryNote::class, $loadedDeliveryNote);
        $this->assertEquals($deliveryNote->getAddress(), $loadedDeliveryNote->getAddress());
    }
}
