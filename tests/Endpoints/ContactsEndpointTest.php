<?php

namespace Tests\Endpoints;

use PHPUnit\Framework\TestCase;
use Lexoffice\Api\Endpoints\ContactsEndpoint;
use Lexoffice\API\Client;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\Contacts\Contact;
use Lexoffice\Entities\Contacts\ContactResource;
use Lexoffice\Entities\Contacts\ContactsPage;
use Lexoffice\Logger\ConsoleLoggerFactory;
use Psr\Log\LoggerInterface;
use Tests\TestAPIClientFactory;

class ContactsEndpointTest extends TestCase {
    private ?Client $client;
    private ?SearchableEndpointInterface $endpoint;
    private ?LoggerInterface $logger = null;

    private bool $apiDisabled = true;

    public function __construct($name) {
        parent::__construct($name);
        $this->logger = ConsoleLoggerFactory::getLogger();
        $this->client = TestAPIClientFactory::getClient();
        $this->endpoint = new ContactsEndpoint($this->client);
    }

    protected function setUp(): void {
        if (!$this->apiDisabled && !is_null($this->client)) {
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
            "version" => 0,
            "roles" => [
                "customer" => []
            ],
            "person" => [
                "salutation" => "Frau",
                "firstName" => "Inge",
                "lastName" => "Musterfrau"
            ],
            "note" => "Notizen"
        ];

        $data1 = [
            "version" => 0,
            "roles" => [
                "customer" => [
                    "number" => 10001
                ]
            ],
            "person" => [
                "salutation" => "Frau",
                "firstName" => "Inge",
                "lastName" => "Musterfrau"
            ],
            "note" => "Notizen"
        ];
        $contact = new Contact($data, $this->logger);
        $contact1 = new Contact($data1, $this->logger);
        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertInstanceOf(Contact::class, $contact1);

        $jsonOriginal = '{"version":0,"roles":{"customer":{}},"person":{"salutation":"Frau","firstName":"Inge","lastName":"Musterfrau"},"note":"Notizen"}';
        $jsonOriginal1 = '{"version":0,"roles":{"customer":{"number":10001}},"person":{"salutation":"Frau","firstName":"Inge","lastName":"Musterfrau"},"note":"Notizen"}';

        $this->assertEquals($jsonOriginal, $contact->toJson());
        $this->assertEquals($jsonOriginal1, $contact1->toJson());
    }

    public function testCreateContactAPI() {
        if ($this->apiDisabled) {
            $this->markTestSkipped('API is disabled');
        }

        $data = [
            "version" => 0,
            "roles" => [
                "customer" => []
            ],
            "person" => [
                "salutation" => "Frau",
                "firstName" => "Inge",
                "lastName" => "Musterfrau"
            ],
            "note" => "Notizen"
        ];
        $contact = new Contact($data, $this->logger);

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
                "customer" => []
            ],
            "person" => [
                "salutation" => "Herr",
                "firstName" => "Max",
                "lastName" => "Mustermann"
            ],
            "note" => "Notizen"
        ];

        $contactResource = $this->endpoint->create(new Contact($data, $this->logger));
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
                "customer" => []
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

        $contactResource = $this->endpoint->create(new Contact($data, $this->logger));
        $this->assertInstanceOf(ContactResource::class, $contactResource);

        $contactsPageUpdated = $this->endpoint->search();
        $this->assertInstanceOf(ContactsPage::class, $contactsPageUpdated);
        $this->assertGreaterThan($contactsPage->getTotalElements(), $contactsPageUpdated->getTotalElements());
    }
}
