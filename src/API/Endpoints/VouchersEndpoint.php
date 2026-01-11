<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VouchersEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;
use InvalidArgumentException;
use Lexoffice\Contracts\Interfaces\API\SearchableEndpointInterface;
use Lexoffice\Entities\Vouchers\Voucher;
use Lexoffice\Entities\Vouchers\VoucherResource;
use Lexoffice\Entities\Vouchers\VouchersPage;

class VouchersEndpoint extends EndpointAbstract implements SearchableEndpointInterface {
    protected string $endpoint = 'vouchers';

    public function create(NamedEntityInterface $data, ?ID $id = null): VoucherResource {
        self::logDebug('Creating voucher', ['endpoint' => $this->endpoint]);

        return self::logInfoWithTimer(function () use ($data) {
            $response = $this->client->post($this->getEndpointUrl(), [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 200);

            return VoucherResource::fromJson($body);
        }, 'Voucher created');
    }

    public function get(?ID $id = null): Voucher {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a voucher');
        }

        self::logDebug('Fetching voucher', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn() => Voucher::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Voucher fetched (ID: {$id->toString()})"
        );
    }

    public function update(ID $id, NamedEntityInterface $data): VoucherResource {
        self::logDebug('Updating voucher', ['id' => $id->toString()]);

        return self::logInfoWithTimer(function () use ($id, $data) {
            $response = $this->client->put("{$this->getEndpointUrl()}/{$id->toString()}", [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 200);

            return VoucherResource::fromJson($body);
        }, "Voucher updated (ID: {$id->toString()})");
    }

    public function delete(ID $id): bool {
        self::logErrorAndThrow(NotAllowedException::class, 'Vouchers cannot be deleted');
    }

    public function search(array $queryParams = [], array $options = []): VouchersPage {
        if (!isset($queryParams['voucherNumber'])) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'voucherNumber is required in $queryParams');
        }

        self::logDebug('Searching vouchers', ['queryParams' => $queryParams]);

        return self::logDebugWithTimer(
            fn() => VouchersPage::fromJson(parent::getContents($queryParams, $options)),
            'Vouchers search completed'
        );
    }
}
