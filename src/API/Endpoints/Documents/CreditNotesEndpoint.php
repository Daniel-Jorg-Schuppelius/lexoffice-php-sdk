<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\CreditNotes\CreditNote;
use Lexoffice\Entities\Documents\CreditNotes\CreditNoteResource;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;
use Lexoffice\Exceptions\NotAllowedException;

class CreditNotesEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'credit-notes';

    public function create(NamedEntityInterface $data, ID $id = null): CreditNoteResource {
        if (!$data->isValid()) {
            throw new \InvalidArgumentException('Data is not valid');
        }

        $response = $this->client->post($this->endpoint, [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return CreditNoteResource::fromJson($body);
    }

    public function get(ID $id): CreditNote {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return CreditNote::fromJson($body);
    }

    public function update(ID $id, NamedEntityInterface $data): CreditNoteResource {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function delete(ID $id): bool {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function render(ID $id): DocumentFileID {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}/document");
        $body = $this->handleResponse($response, 200);

        return DocumentFileID::fromJson($body);
    }

    public function pursue(VoucherID $id, bool $finalize = false): CreditNoteResource {
        $response = $this->client->get("{$this->endpoint}?precedingSalesVoucherId={$id->toString()}[&finalize=$finalize]");
        $body = $this->handleResponse($response, 200);

        return CreditNote::fromJson($body);
    }
}
