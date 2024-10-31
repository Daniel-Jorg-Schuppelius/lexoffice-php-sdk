<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : CreditNotesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\CreditNotes\CreditNote;
use Lexoffice\Entities\Documents\CreditNotes\CreditNoteResource;
use APIToolkit\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

class CreditNotesEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'credit-notes';

    public function create(NamedEntityInterface $data, ID $id = null): CreditNoteResource {
        if (!$data->isValid()) {
            throw new \InvalidArgumentException('Data is not valid');
        }

        $response = $this->client->post($this->getEndpointUrl(), [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return CreditNoteResource::fromJson($body);
    }

    public function get(?ID $id = null): CreditNote {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return CreditNote::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}"));
    }

    public function pursue(VoucherID $id, bool $finalize = false): CreditNoteResource {
        return CreditNoteResource::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}?precedingSalesVoucherId={$id->toString()}[&finalize=$finalize]"));
    }
}
