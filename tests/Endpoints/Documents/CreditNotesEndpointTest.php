<?php

namespace Tests\Endpoints\Documents;

use PHPUnit\Framework\TestCase;
use Lexoffice\API\Client;
use Lexoffice\Api\Endpoints\Documents\CreditNotesEndpoint;
use Lexoffice\Contracts\Interfaces\API\DocumentEndpointInterface;
use Lexoffice\Entities\Documents\CreditNotes\CreditNote;
use Lexoffice\Entities\Documents\CreditNotes\CreditNoteResource;
use Lexoffice\Logger\ConsoleLogger;
use Tests\Config\PostmanConfig;

class CreditNotesEndpointTest extends TestCase {
    private ?Client $client;
    private ?DocumentEndpointInterface $endpoint;
    private ?PostmanConfig $config;
    private ?ConsoleLogger $logger = null;

    private bool $apiDisabled = false;

    public function __construct($name) {
        parent::__construct($name);
        $this->config = new PostmanConfig();
        //$this->logger = new ConsoleLogger();
        $this->client = new Client($this->config->accessToken, $this->config->resourceUrl . '/v1/', $this->logger, true);
        $this->endpoint = new CreditNotesEndpoint($this->client);
    }

    protected function setUp(): void {
        if (!$this->apiDisabled && $this->config->isConfigured()) {
            try {
                $response = $this->client->get("ping");
                $this->apiDisabled = $response->getStatusCode() != 200;
            } catch (\Exception $e) {
                $this->apiDisabled = true;
            }
        } else {
            $this->apiDisabled = true;
        }
    }

    public function testJsonSerialize() {
        $data = [
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
                        "taxRatePercentage" => 0
                    ]
                ],
                [
                    "type" => "text",
                    "name" => "Strukturieren Sie Ihre Belege durch Text-Elemente.",
                    "description" => "Das hilft beim Verständnis"
                ]
            ],
            "archived" => false,
            "voucherDate" => "2024-02-22T00:00:00.000+01:00",
            "address" => [
                "name" => "Bike & Ride GmbH & Co. KG",
                "supplement" => "Gebäude 10",
                "street" => "Musterstraße 42",
                "zip" => "79112",
                "city" => "Freiburg",
                "countryCode" => "DE"
            ],
            "totalPrice" => [
                "currency" => "EUR"
            ],
            "taxConditions" => [
                "taxType" => "net"
            ],
            "title" => "Rechnungskorrektur",
            "introduction" => "Rechnungskorrektur zur Rechnung RE-00020",
            "remark" => "Folgende Lieferungen/Leistungen schreiben wir Ihnen gut."
        ];

        $creditNote = new CreditNote($data);
        $this->assertEquals($data, $creditNote->toArray());
        $this->assertEquals(json_encode($data), $creditNote->toJson());
        $this->assertStringNotContainsString('lineItems":{"0":', $creditNote->toJson());
        $this->assertStringContainsString(substr($creditNote->title, 2, -2), $creditNote->toJson());
    }

    public function testCreateAndGetCreditNoteAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "archived" => false,
            "voucherDate" => "2024-02-22T00:00:00.000+01:00",
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
                        "taxRatePercentage" => 0
                    ]
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
            "title" => "Rechnungskorrektur",
            "introduction" => "Rechnungskorrektur zur Rechnung RE-00020",
            "remark" => "Folgende Lieferungen/Leistungen schreiben wir Ihnen gut."
        ];

        $creditNote = new CreditNote($data);
        $creditNoteResource = $this->endpoint->create($creditNote);
        $this->assertInstanceOf(CreditNoteResource::class, $creditNoteResource);
        $loadedCreditNote = $this->endpoint->get($creditNoteResource->getId());
        $this->assertInstanceOf(CreditNote::class, $loadedCreditNote);
        $this->assertEquals($creditNote->address, $loadedCreditNote->address);
    }
}
