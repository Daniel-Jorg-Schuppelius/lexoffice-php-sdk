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

        return DownPaymentInvoice::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }
}
