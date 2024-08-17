<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\OrderConfirmations\OrderConfirmation;
use Lexoffice\Entities\Documents\OrderConfirmations\OrderConfirmationResource;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

class OrderConfirmationsEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'order-confirmations';

    public function create(NamedEntityInterface $data, ID $id = null): OrderConfirmationResource {
        if (!$data->isValid()) {
            throw new \InvalidArgumentException('Data is not valid');
        }

        $response = $this->client->post($this->endpoint, [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return OrderConfirmationResource::fromJson($body);
    }

    public function get(ID $id): OrderConfirmation {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return OrderConfirmation::fromJson($body);
    }

    public function render(ID $id): DocumentFileID {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}/document");
        $body = $this->handleResponse($response, 200);

        return DocumentFileID::fromJson($body);
    }

    public function pursue(VoucherID $id, bool $finalize = false): OrderConfirmationResource {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return OrderConfirmation::fromJson($body);
    }
}
