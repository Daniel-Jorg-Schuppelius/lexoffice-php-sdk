<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\CreditNotes\CreditNote;
use Lexoffice\Entities\Documents\CreditNotes\CreditNoteResource;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

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

    public function get(?ID $id = null): CreditNote {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return CreditNote::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }

    public function pursue(VoucherID $id, bool $finalize = false): CreditNoteResource {
        return CreditNoteResource::fromJson(parent::getContents([], [], "{$this->endpoint}?precedingSalesVoucherId={$id->toString()}[&finalize=$finalize]"));
    }
}
