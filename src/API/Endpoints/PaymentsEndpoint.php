<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Entities\Payments\Payment;
use Lexoffice\Entities\ID;

class PaymentsEndpoint extends BaseEndpointAbstract {
    protected string $endpoint = 'payments';

    public function get(?ID $id = null): Payment {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return Payment::fromJson($body);
    }
}
