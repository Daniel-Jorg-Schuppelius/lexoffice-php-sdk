<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : ContactsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ClassicEndpointInterface;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Contacts\Contact;
use Lexoffice\Entities\Contacts\ContactResource;
use Lexoffice\Entities\Contacts\ContactsPage;
use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;

class ContactsEndpoint extends EndpointAbstract implements ClassicEndpointInterface, SearchableEndpointInterface {
    protected string $endpoint = 'contacts';

    public function create(NamedEntityInterface $data, ID $id = null): ContactResource {
        $response = $this->client->post($this->getEndpointUrl(), [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 200);

        return ContactResource::fromJson($body);
    }

    public function get(?ID $id = null): Contact {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return Contact::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}"));
    }

    public function update(ID $id, NamedEntityInterface $data): ContactResource {
        $response = $this->client->put("{$this->getEndpointUrl()}/{$id->toString()}", [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 200);

        return ContactResource::fromJson($body);
    }

    public function delete(ID $id): bool {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function search(array $queryParams = [], array $options = []): ContactsPage {
        return ContactsPage::fromJson(parent::getContents($queryParams, $options));
    }
}
