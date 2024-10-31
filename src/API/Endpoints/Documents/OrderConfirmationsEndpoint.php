<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : OrderConfirmationsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\OrderConfirmations\OrderConfirmation;
use Lexoffice\Entities\Documents\OrderConfirmations\OrderConfirmationResource;
use APIToolkit\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;

class OrderConfirmationsEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'order-confirmations';

    public function create(NamedEntityInterface $data, ID $id = null): OrderConfirmationResource {
        if (!$data->isValid()) {
            throw new \InvalidArgumentException('Data is not valid');
        }

        $response = $this->client->post($this->getEndpointUrl(), [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return OrderConfirmationResource::fromJson($body);
    }

    public function get(?ID $id = null): OrderConfirmation {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return OrderConfirmation::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}"));
    }

    public function pursue(VoucherID $id, bool $finalize = false): OrderConfirmationResource {
        return OrderConfirmationResource::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}?precedingSalesVoucherId={$id->toString()}"));
    }
}
