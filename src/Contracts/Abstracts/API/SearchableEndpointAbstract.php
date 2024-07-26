<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

abstract class SearchableEndpointAbstract extends EndpointAbstract implements SearchableEndpointInterface {
    protected function getEntities(string $entityClass, array $queryParams = []) {
        $queryString = http_build_query($queryParams);
        $response = $this->client->get("{$this->endpoint}?{$queryString}");
        $body = $this->handleResponse($response, 200);

        throw new \Exception('Method not implemented');
    }
}
