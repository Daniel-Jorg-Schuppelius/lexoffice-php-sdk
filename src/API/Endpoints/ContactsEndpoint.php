<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\SearchableEndpointAbstract;
use Lexoffice\Entities\Contacts\Contact;
use Lexoffice\Entities\Contacts\ContactResource;
use Lexoffice\Entities\Contacts\ContactsPage;
use Lexoffice\Exceptions\ApiException;

class ContactsEndpoint extends SearchableEndpointAbstract {
    protected string $endpoint = 'contacts';

    public function create(array $data): ContactResource {
        $response = $this->client->post($this->endpoint, [
            'json' => $data,
        ]);
        $body = $this->handleResponse($response, 200);

        return ContactResource::fromArray($body);
    }

    public function get(string $id): Contact {
        $response = $this->client->get("{$this->endpoint}/{$id}");
        $body = $this->handleResponse($response, 200);

        return Contact::fromArray($body);
    }

    public function update(string $id, array $data): ContactResource {
        $response = $this->client->put("{$this->endpoint}/{$id}", [
            'json' => $data,
        ]);
        $body = $this->handleResponse($response, 200);

        return ContactResource::fromArray($body);
    }

    public function delete(string $id): bool {
        throw new ApiException('Not Allowed', 405);
    }

    public function search(array $queryParams = []): ContactsPage {
        $response = $this->client->get($this->endpoint, $queryParams);
        $body = $this->handleResponse($response, 200);

        return ContactsPage::fromArray($body);
    }
}
