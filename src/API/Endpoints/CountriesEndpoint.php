<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\ClassicEndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Contracts\Interfaces\ResourceInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Countries\Countries;
use Lexoffice\Entities\Countries\Country;
use Lexoffice\Entities\ID;
use Lexoffice\Exceptions\NotAllowedException;

class CountriesEndpoint extends ClassicEndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'countries';

    public function create(NamedEntityInterface $data, ID $id = null): ResourceInterface {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function get(ID $id): Country {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function update(ID $id, NamedEntityInterface $data): ResourceInterface {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function delete(ID $id): bool {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function list(array $queryParams = []): Countries {
        $response = $this->client->get($this->endpoint, $queryParams);
        $this->handleResponse($response, 200);

        return Countries::fromJson($response->getBody());
    }
}
