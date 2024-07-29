<?php

namespace Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use Lexoffice\Api\Endpoints\ContactsEndpoint;
use Lexoffice\API\Client;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\Contacts\Contact;
use Lexoffice\Entities\Contacts\ContactResource;
use Lexoffice\Entities\Contacts\ContactsPage;
use Lexoffice\Logger\ConsoleLogger;
use Tests\Config\PostmanConfig;

class ContactsEndpointTest extends TestCase {
    private ?Client $client;
    private ?SearchableEndpointInterface $endpoint;
    private ?PostmanConfig $config;
    private ?ConsoleLogger $logger = null;

    private bool $apiDisabled = true;

    public function __construct($name) {
        parent::__construct($name);
        $this->config = new PostmanConfig();
        //$this->logger = new ConsoleLogger();
        $this->client = new Client($this->config->accessToken, $this->config->resourceUrl . '/v1/', $this->logger, true);
        $this->endpoint = new ContactsEndpoint($this->client);
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

    public function testCreateContactAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "version" => 0,
            "roles" => [
                "customer" => [
                    // Weitere Details hier, falls vorhanden
                ]
            ],
            "person" => [
                "salutation" => "Frau",
                "firstName" => "Inge",
                "lastName" => "Musterfrau"
            ],
            "note" => "Notizen"
        ];
        $contact = new Contact($data);

        $contactResource = $this->endpoint->create($contact);
        $this->assertInstanceOf(ContactResource::class, $contactResource);
    }

    public function testCreateGetAndUpdateContactAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "version" => 0,
            "roles" => [
                "customer" => [
                    // Weitere Details hier, falls vorhanden
                ]
            ],
            "person" => [
                "salutation" => "Herr",
                "firstName" => "Max",
                "lastName" => "Mustermann"
            ],
            "note" => "Notizen"
        ];

        $contactResource = $this->endpoint->create(new Contact($data));
        $this->assertInstanceOf(ContactResource::class, $contactResource);
        $contact = $this->endpoint->get($contactResource->getId());

        $person = $contact->person;
        $person->firstName = "Maximilian";
        $contactResourceUpdated = $this->endpoint->update($contactResource->getId(), $contact);
        $this->assertInstanceOf(ContactResource::class, $contactResourceUpdated);
    }

    public function testCreateANDSearchContactAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "version" => 0,
            "roles" => [
                "customer" => [
                    // Weitere Details hier, falls vorhanden
                ]
            ],
            "person" => [
                "salutation" => "Frau",
                "firstName" => "Inge",
                "lastName" => "Musterfrau"
            ],
            "note" => "Notizen"
        ];

        $contactsPage = $this->endpoint->search();
        $this->assertInstanceOf(ContactsPage::class, $contactsPage);

        $contactResource = $this->endpoint->create(new Contact($data));
        $this->assertInstanceOf(ContactResource::class, $contactResource);

        $contactsPageUpdated = $this->endpoint->search();
        $this->assertInstanceOf(ContactsPage::class, $contactsPageUpdated);
        $this->assertGreaterThan($contactsPage->getTotalElements(), $contactsPageUpdated->getTotalElements());
    }
}
