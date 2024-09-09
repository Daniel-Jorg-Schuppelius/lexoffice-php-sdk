<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\Quotations\Quotation;
use Lexoffice\Entities\Documents\Quotations\QuotationResource;
use APIToolkit\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;
use Lexoffice\Exceptions\NotAllowedException;

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

        return Quotation::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }

    public function pursue(VoucherID $id, bool $finalize = false): QuotationResource {
        throw new NotAllowedException('Quotations cannot be pursued');
    }
}
