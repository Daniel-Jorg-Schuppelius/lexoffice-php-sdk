<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : OrderConfirmationsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints\Documents;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Entities\Documents\OrderConfirmations\{OrderConfirmation, OrderConfirmationResource};
use Lexoffice\Entities\Vouchers\VoucherID;

class OrderConfirmationsEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'order-confirmations';

    public function create(NamedEntityInterface $data, ?ID $id = null, bool $finalize = false): OrderConfirmationResource {
        if (!$data->isValid()) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'Order confirmation data is not valid');
        }

        self::logDebug('Creating order confirmation', ['endpoint' => $this->endpoint, 'finalize' => $finalize]);

        return self::logInfoWithTimer(function () use ($data, $finalize) {
            $url = $this->getEndpointUrl();
            if ($finalize) {
                $url .= '?finalize=true';
            }
            $response = $this->client->post($url, [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 201);

            return OrderConfirmationResource::fromJson($body);
        }, 'Order confirmation created');
    }

    public function get(?ID $id = null): OrderConfirmation {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting an order confirmation');
        }

        self::logDebug('Fetching order confirmation', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn () => OrderConfirmation::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Order confirmation fetched (ID: {$id->toString()})"
        );
    }

    public function pursue(VoucherID $id, bool $finalize = false): OrderConfirmationResource {
        self::logDebug('Pursuing order confirmation from voucher', ['voucherId' => $id->toString()]);

        return self::logInfoWithTimer(function () use ($id) {
            $url = "{$this->getEndpointUrl()}?precedingSalesVoucherId={$id->toString()}";
            $response = $this->client->post($url, ['body' => '{}']);
            $body = $this->handleResponse($response, 201);

            return OrderConfirmationResource::fromJson($body);
        }, "Order confirmation pursued from voucher (ID: {$id->toString()})");
    }
}
