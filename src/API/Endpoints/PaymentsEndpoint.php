<?php

namespace Lexoffice\Api\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Entities\Payments\Payment;
use APIToolkit\Entities\ID;

class PaymentsEndpoint extends EndpointAbstract {
    protected string $endpoint = 'payments';

    public function get(?ID $id = null): Payment {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return Payment::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }
}
