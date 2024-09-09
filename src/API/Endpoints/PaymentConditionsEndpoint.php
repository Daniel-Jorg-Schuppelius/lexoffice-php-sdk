<?php

namespace Lexoffice\Api\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Contracts\Interfaces\API\ListableEndpointInterface;
use Lexoffice\Entities\PaymentConditions\PaymentCondition;
use Lexoffice\Entities\PaymentConditions\PaymentConditions;
use APIToolkit\Entities\ID;
use Lexoffice\Exceptions\NotAllowedException;

class PaymentConditionsEndpoint extends EndpointAbstract implements ListableEndpointInterface {
    protected string $endpoint = 'payment-conditions';

    public function get(?ID $id = null): PaymentCondition {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function list(array $options = []): PaymentConditions {
        return PaymentConditions::fromJson(parent::getContents([], $options));
    }
}
