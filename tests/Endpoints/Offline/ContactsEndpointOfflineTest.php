<?php
/*
 * Created on   : Sat Jan 11 2026
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ContactsEndpointOfflineTest.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Tests\Endpoints\Offline;

use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;
use InvalidArgumentException;
use Lexoffice\API\Endpoints\ContactsEndpoint;
use Lexoffice\Entities\Contacts\{Contact, ContactResource, ContactsPage};
use Tests\Contracts\OfflineEndpointTest;

class ContactsEndpointOfflineTest extends OfflineEndpointTest {
    private ContactsEndpoint $endpoint;

    protected function setUp(): void {
        parent::setUp();
        $this->endpoint = new ContactsEndpoint($this->mockClient, $this->logger);
    }

    protected function setupMockResponses(): void {
        $this->mockClient->addResponse('POST', 'contacts', 200, json_encode([
            'id' => 'e9066f04-8cc7-4616-93f8-ac9571762f49',
            'resourceUri' => 'https://api.lexoffice.io/v1/contacts/e9066f04-8cc7-4616-93f8-ac9571762f49',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T10:30:00.000+01:00',
            'version' => 0,
        ]));

        $this->mockClient->addResponse('GET', 'contacts/e9066f04-8cc7-4616-93f8-ac9571762f49', 200, json_encode([
            'id' => 'e9066f04-8cc7-4616-93f8-ac9571762f49',
            'version' => 0,
            'roles' => [
                'customer' => [],
            ],
            'person' => [
                'salutation' => 'Herr',
                'firstName' => 'Max',
                'lastName' => 'Mustermann',
            ],
            'note' => 'Test contact',
        ]));

        $this->mockClient->addResponse('GET', 'contacts', 200, json_encode([
            'content' => [],
            'first' => true,
            'last' => true,
            'totalPages' => 0,
            'totalElements' => 0,
            'numberOfElements' => 0,
            'size' => 25,
            'number' => 0,
            'sort' => [],
        ]));
    }

    public function test_create_contact(): void {
        $data = [
            'version' => 0,
            'roles' => [
                'customer' => [],
            ],
            'person' => [
                'salutation' => 'Herr',
                'firstName' => 'Max',
                'lastName' => 'Mustermann',
            ],
            'note' => 'Test contact',
        ];

        $contact = new Contact($data);
        $result = $this->endpoint->create($contact);

        $this->assertInstanceOf(ContactResource::class, $result);
        $this->assertEquals('e9066f04-8cc7-4616-93f8-ac9571762f49', $result->getId()->toString());
        $this->assertRequestMade('POST', 'contacts');
    }

    public function test_get_contact(): void {
        $id = new ID('e9066f04-8cc7-4616-93f8-ac9571762f49');
        $result = $this->endpoint->get($id);

        $this->assertInstanceOf(Contact::class, $result);
        $this->assertEquals('Max', $result->getPerson()->getFirstName());
        $this->assertEquals('Mustermann', $result->getPerson()->getLastName());
        $this->assertRequestMade('GET', 'contacts/e9066f04-8cc7-4616-93f8-ac9571762f49');
    }

    public function test_get_contact_without_id_throws_exception(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('ID is required');

        $this->endpoint->get(null);
    }

    public function test_update_contact(): void {
        $this->mockClient->addResponse('PUT', 'contacts/e9066f04-8cc7-4616-93f8-ac9571762f49', 200, json_encode([
            'id' => 'e9066f04-8cc7-4616-93f8-ac9571762f49',
            'resourceUri' => 'https://api.lexoffice.io/v1/contacts/e9066f04-8cc7-4616-93f8-ac9571762f49',
            'createdDate' => '2024-03-15T10:30:00.000+01:00',
            'updatedDate' => '2024-03-15T11:00:00.000+01:00',
            'version' => 1,
        ]));

        $id = new ID('e9066f04-8cc7-4616-93f8-ac9571762f49');
        $contact = new Contact([
            'version' => 0,
            'roles' => ['customer' => []],
            'person' => [
                'salutation' => 'Herr',
                'firstName' => 'Max',
                'lastName' => 'Mustermann Updated',
            ],
        ]);

        $result = $this->endpoint->update($id, $contact);

        $this->assertInstanceOf(ContactResource::class, $result);
        $this->assertRequestMade('PUT', 'contacts/e9066f04-8cc7-4616-93f8-ac9571762f49');
    }

    public function test_delete_contact_throws_not_allowed_exception(): void {
        $this->expectException(NotAllowedException::class);
        $this->expectExceptionMessage('Deleting contacts is not allowed');

        $id = new ID('e9066f04-8cc7-4616-93f8-ac9571762f49');
        $this->endpoint->delete($id);
    }

    public function test_search_contacts(): void {
        $result = $this->endpoint->search();

        $this->assertInstanceOf(ContactsPage::class, $result);
        $this->assertRequestMade('GET', 'contacts*');
    }

    public function test_search_contacts_with_filters(): void {
        $result = $this->endpoint->search(['email' => 'test@example.com']);

        $this->assertInstanceOf(ContactsPage::class, $result);
        $this->assertRequestMade('GET', 'contacts*');
    }
}
