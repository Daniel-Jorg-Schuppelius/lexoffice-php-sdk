<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNote;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNoteResource;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

class DeliveryNotesEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'delivery-notes';

    public function create(NamedEntityInterface $data, ID $id = null): DeliveryNoteResource {
        $response = $this->client->post($this->endpoint, [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return DeliveryNoteResource::fromJson($body);
    }

    public function get(ID $id): DeliveryNote {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return DeliveryNote::fromJson($body);
    }

    public function render(ID $id): DocumentFileID {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}/document");
        $body = $this->handleResponse($response, 200);

        return DocumentFileID::fromJson($body);
    }

    public function pursue(VoucherID $id, bool $finalize = false): DeliveryNoteResource {
        $response = $this->client->get("{$this->endpoint}?precedingSalesVoucherId={$id->toString()}[&finalize=$finalize]");
        $body = $this->handleResponse($response, 200);

        return DeliveryNote::fromJson($body);
    }
}
