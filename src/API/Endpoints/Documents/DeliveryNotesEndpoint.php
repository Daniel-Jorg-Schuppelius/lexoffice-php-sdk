<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DeliveryNotesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNote;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNoteResource;
use APIToolkit\Entities\ID;
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

    public function get(?ID $id = null): DeliveryNote {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return DeliveryNote::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }

    public function pursue(VoucherID $id, bool $finalize = false): DeliveryNoteResource {
        return DeliveryNoteResource::fromJson(parent::getContents([], [], "{$this->endpoint}?precedingSalesVoucherId={$id->toString()}"));
    }
}
