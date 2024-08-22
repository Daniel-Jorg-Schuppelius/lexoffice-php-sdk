<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\Invoices\Invoice;
use Lexoffice\Entities\Documents\Invoices\InvoiceResource;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

class InvoicesEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'invoices';

    public function create(NamedEntityInterface $data, ID $id = null): InvoiceResource {
        if (!$data->isValid()) {
            throw new \InvalidArgumentException('Data is not valid');
        }

        $response = $this->client->post($this->endpoint, [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return InvoiceResource::fromJson($body);
    }

    public function get(?ID $id = null): Invoice {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return Invoice::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }

    public function pursue(VoucherID $id, bool $finalize = false): InvoiceResource {
        return InvoiceResource::fromJson(parent::getContents([], [], "{$this->endpoint}?precedingSalesVoucherId={$id->toString()}[&finalize=$finalize]"));
    }
}
