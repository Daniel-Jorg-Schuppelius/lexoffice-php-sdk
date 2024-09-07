<?php

namespace Lexoffice\Api\Endpoints\Documents;

use InvalidArgumentException;
use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\Dunnings\Dunning;
use Lexoffice\Entities\Documents\Dunnings\DunningResource;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

class DunningsEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'dunnings';

    public function create(NamedEntityInterface $data, ID $id = null): DunningResource {
        if (is_null($id)) {
            throw new InvalidArgumentException('$id (PrecedingSalesVoucherID) is required');
        }

        $response = $this->client->post("{$this->endpoint}?precedingSalesVoucherId={$id->toString()}", [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return DunningResource::fromJson($body);
    }

    public function get(?ID $id = null): Dunning {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return Dunning::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }

    public function pursue(VoucherID $id, bool $finalize = false): DunningResource {
        return DunningResource::fromJson(parent::getContents([], [], "{$this->endpoint}?precedingSalesVoucherId={$id->toString()}"));
    }
}
