<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\BaseEndpointAbstract;
use Lexoffice\Entities\Documents\DownPaymentInvoices\DownPaymentInvoice;
use Lexoffice\Entities\ID;

class DownPaymentInvoicesEndpoint extends BaseEndpointAbstract {
    protected string $endpoint = 'down-payment-invoices';

    public function get(?ID $id = null): DownPaymentInvoice {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return DownPaymentInvoice::fromJson($body);
    }
}
