<?php

namespace Lexoffice\Api\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PostingCategories\PostingCategory;
use Lexoffice\Entities\PostingCategories\PostingCategories;
use APIToolkit\Entities\ID;
use Lexoffice\Exceptions\NotAllowedException;

class PostingCategoriesEndpoint extends EndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'payment-conditions';

    public function get(?ID $id = null): PostingCategory {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function list(array $options = []): PostingCategories {
        return PostingCategories::fromJson(parent::getContents([], $options));
    }
}
