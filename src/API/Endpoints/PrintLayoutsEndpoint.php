<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PrintLayouts\PrintLayout;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\PrintLayouts\PrintLayouts;
use Lexoffice\Exceptions\NotAllowedException;

class PrintLayoutsEndpoint extends BaseEndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'print-layouts';

    public function get(?ID $id = null): PrintLayout {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function list(array $queryParams = [], array $options = []): PrintLayouts {
        $params = "?" . http_build_query($queryParams) ?? '';
        $response = $this->client->get($this->endpoint . $params, $options);
        $this->handleResponse($response, 200);

        return PrintLayouts::fromJson($response->getBody());
    }
}
