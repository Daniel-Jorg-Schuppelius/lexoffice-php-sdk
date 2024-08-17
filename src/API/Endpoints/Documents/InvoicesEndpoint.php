<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\Invoices\Invoice;
use Lexoffice\Entities\Documents\Invoices\InvoiceResource;
use Lexoffice\Entities\Documents\DocumentFileID;
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

        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return Invoice::fromJson($body);
    }

    public function render(ID $id): DocumentFileID {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}/document");
        $body = $this->handleResponse($response, 200);

        return DocumentFileID::fromJson($body);
    }

    public function pursue(VoucherID $id, bool $finalize = false): InvoiceResource {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return Invoice::fromJson($body);
    }
}
