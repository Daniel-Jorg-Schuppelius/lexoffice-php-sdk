<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\Quotations\Quotation;
use Lexoffice\Entities\Documents\Quotations\QuotationResource;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

class QuotationsEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'quotations';

    public function create(NamedEntityInterface $data, ID $id = null): QuotationResource {
        if (!$data->isValid()) {
            throw new \InvalidArgumentException('Data is not valid');
        }

        $response = $this->client->post($this->endpoint, [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return QuotationResource::fromJson($body);
    }

    public function get(?ID $id = null): Quotation {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return Quotation::fromJson($body);
    }

    public function render(ID $id): DocumentFileID {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}/document");
        $body = $this->handleResponse($response, 200);

        return DocumentFileID::fromJson($body);
    }

    public function pursue(VoucherID $id, bool $finalize = false): QuotationResource {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return Quotation::fromJson($body);
    }
}
