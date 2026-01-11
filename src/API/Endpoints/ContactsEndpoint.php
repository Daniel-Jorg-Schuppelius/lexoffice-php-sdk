<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ContactsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;
use InvalidArgumentException;
use Lexoffice\Contracts\Interfaces\API\ClassicEndpointInterface;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\Contacts\Contact;
use Lexoffice\Entities\Contacts\ContactResource;
use Lexoffice\Entities\Contacts\ContactsPage;

class ContactsEndpoint extends EndpointAbstract implements ClassicEndpointInterface, SearchableEndpointInterface {
    protected string $endpoint = 'contacts';

    public function create(NamedEntityInterface $data, ?ID $id = null): ContactResource {
        self::logDebug('Creating contact', ['endpoint' => $this->endpoint]);

        return self::logInfoWithTimer(function () use ($data) {
            $response = $this->client->post($this->getEndpointUrl(), [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 200);

            return ContactResource::fromJson($body);
        }, 'Contact created');
    }

    public function get(?ID $id = null): Contact {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a contact');
        }

        self::logDebug('Fetching contact', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn() => Contact::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Contact fetched (ID: {$id->toString()})"
        );
    }

    public function update(ID $id, NamedEntityInterface $data): ContactResource {
        self::logDebug('Updating contact', ['id' => $id->toString()]);

        return self::logInfoWithTimer(function () use ($id, $data) {
            $response = $this->client->put("{$this->getEndpointUrl()}/{$id->toString()}", [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 200);

            return ContactResource::fromJson($body);
        }, "Contact updated (ID: {$id->toString()})");
    }

    public function delete(ID $id): bool {
        self::logErrorAndThrow(NotAllowedException::class, 'Deleting contacts is not allowed', [], null, 405);
    }

    public function search(array $queryParams = [], array $options = []): ContactsPage {
        self::logDebug('Searching contacts', ['queryParams' => $queryParams]);

        return self::logDebugWithTimer(
            fn() => ContactsPage::fromJson(parent::getContents($queryParams, $options)),
            'Contacts search completed'
        );
    }
}
