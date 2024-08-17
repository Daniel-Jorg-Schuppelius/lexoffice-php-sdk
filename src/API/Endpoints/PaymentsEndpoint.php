<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\Payments\Payments;
use Lexoffice\Entities\Payments\Payment;
use Lexoffice\Entities\ID;

class PaymentsEndpoint extends BaseEndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'payments';

    public function get(ID $id): Payment {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return Payment::fromJson($body);
    }

    public function list(array $queryParams = []): Payments {
        $response = $this->client->get($this->endpoint, $queryParams);
        $this->handleResponse($response, 200);

        return Payments::fromJson($response->getBody());
    }
}
