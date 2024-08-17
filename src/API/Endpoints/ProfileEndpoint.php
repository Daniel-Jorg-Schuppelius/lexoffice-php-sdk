<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Entities\Profile\Profile;
use Lexoffice\Entities\ID;

class ProfileEndpoint extends BaseEndpointAbstract {
    protected string $endpoint = 'profile';

    public function get(?ID $id = null): Profile {
        $response = $this->client->get("{$this->endpoint}");
        $body = $this->handleResponse($response, 200);

        return Profile::fromJson($body);
    }
}
