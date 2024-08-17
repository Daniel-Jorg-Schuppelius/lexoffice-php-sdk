<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PostingCategories\PostingCategory;
use Lexoffice\Entities\PostingCategories\PostingCategories;
use Lexoffice\Entities\ID;
use Lexoffice\Exceptions\NotAllowedException;

class PostingCategoriesEndpoint extends BaseEndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'payment-conditions';

    public function get(ID $id): PostingCategory {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function list(array $queryParams = []): PostingCategories {
        $response = $this->client->get($this->endpoint, $queryParams);
        $this->handleResponse($response, 200);

        return PostingCategories::fromJson($response->getBody());
    }
}
