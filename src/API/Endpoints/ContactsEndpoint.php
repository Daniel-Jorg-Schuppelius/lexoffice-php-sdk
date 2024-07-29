<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\SearchableEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Contacts\Contact;
use Lexoffice\Entities\Contacts\ContactResource;
use Lexoffice\Entities\Contacts\ContactsPage;
use Lexoffice\Entities\ID;
use Lexoffice\Exceptions\ApiException;

class ContactsEndpoint extends SearchableEndpointAbstract {
    protected string $endpoint = 'contacts';

    public function create(NamedEntityInterface $data): ContactResource {
        $response = $this->client->post($this->endpoint, [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 200);

        return ContactResource::fromArray($body);
    }

    public function get(ID $id): Contact {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return Contact::fromArray($body);
    }

    public function update(ID $id, NamedEntityInterface $data): ContactResource {
        $response = $this->client->put("{$this->endpoint}/{$id->toString()}", [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 200);

        return ContactResource::fromArray($body);
    }

    public function delete(ID $id): bool {
        throw new ApiException('Not Allowed', 405);
    }

    public function search(array $queryParams = []): ContactsPage {
        $response = $this->client->get($this->endpoint, $queryParams);
        $body = $this->handleResponse($response, 200);

        return ContactsPage::fromArray($body);
    }
}
