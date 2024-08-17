<?php

namespace Lexoffice\Api\Endpoints;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PaymentConditions\PaymentCondition;
use Lexoffice\Entities\PaymentConditions\PaymentConditions;
use Lexoffice\Entities\ID;
use Lexoffice\Exceptions\NotAllowedException;

class PaymentConditionsEndpoint extends BaseEndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'payment-conditions';

    public function get(ID $id): PaymentCondition {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function list(array $queryParams = []): PaymentConditions {
        $response = $this->client->get($this->endpoint, $queryParams);
        $this->handleResponse($response, 200);

        return PaymentConditions::fromJson($response->getBody());
    }
}
