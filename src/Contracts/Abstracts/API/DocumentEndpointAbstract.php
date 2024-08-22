<?php

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use Lexoffice\Contracts\Interfaces\API\DocumentEndpointInterface;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Contracts\Interfaces\ResourceInterface;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

abstract class DocumentEndpointAbstract extends BaseEndpointAbstract implements DocumentEndpointInterface {
    abstract public function create(NamedEntityInterface $data, ID $id = null): ResourceInterface;
    abstract public function get(?ID $id = null): NamedEntityInterface;
    abstract public function pursue(VoucherID $id, bool $finalize = false): ResourceInterface;

    public function render(ID $id): DocumentFileID {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}/document");
        $body = $this->handleResponse($response, 200);

        return DocumentFileID::fromJson($body);
    }
}
