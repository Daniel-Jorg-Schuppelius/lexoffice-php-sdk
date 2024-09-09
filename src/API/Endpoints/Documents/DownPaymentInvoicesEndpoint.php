<?php

namespace Lexoffice\Api\Endpoints\Documents;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use Lexoffice\Entities\Documents\DownPaymentInvoices\DownPaymentInvoice;
use APIToolkit\Entities\ID;

class DownPaymentInvoicesEndpoint extends EndpointAbstract {
    protected string $endpoint = 'down-payment-invoices';

    public function get(?ID $id = null): DownPaymentInvoice {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return DownPaymentInvoice::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }
}
