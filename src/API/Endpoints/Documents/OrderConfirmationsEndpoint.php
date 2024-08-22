<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\OrderConfirmations\OrderConfirmation;
use Lexoffice\Entities\Documents\OrderConfirmations\OrderConfirmationResource;
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

    public function get(?ID $id = null): OrderConfirmation {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return OrderConfirmation::fromJson(parent::getContents([], [], "{$this->endpoint}/{$id->toString()}"));
    }

    public function pursue(VoucherID $id, bool $finalize = false): OrderConfirmationResource {
        return OrderConfirmationResource::fromJson(parent::getContents([], [], "{$this->endpoint}?precedingSalesVoucherId={$id->toString()}"));
    }
}
