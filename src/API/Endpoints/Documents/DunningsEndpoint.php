<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DunningsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints\Documents;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Entities\Documents\Dunnings\{Dunning, DunningResource};
use Lexoffice\Entities\Vouchers\VoucherID;

class DunningsEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'dunnings';

    public function create(NamedEntityInterface $data, ?ID $id = null, bool $finalize = false): DunningResource {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, '$id (PrecedingSalesVoucherID) is required for creating a dunning');
        }

        self::logDebug('Creating dunning', ['precedingSalesVoucherId' => $id->toString(), 'finalize' => $finalize]);

        return self::logInfoWithTimer(function () use ($id, $data, $finalize) {
            $url = "{$this->getEndpointUrl()}?precedingSalesVoucherId={$id->toString()}";
            if ($finalize) {
                $url .= '&finalize=true';
            }
            $response = $this->client->post($url, [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 201);

            return DunningResource::fromJson($body);
        }, 'Dunning created');
    }

    public function get(?ID $id = null): Dunning {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a dunning');
        }

        self::logDebug('Fetching dunning', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn () => Dunning::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Dunning fetched (ID: {$id->toString()})"
        );
    }

    public function pursue(VoucherID $id, bool $finalize = false): DunningResource {
        self::logDebug('Pursuing dunning from voucher', ['voucherId' => $id->toString()]);

        return self::logInfoWithTimer(function () use ($id) {
            $url = "{$this->getEndpointUrl()}?precedingSalesVoucherId={$id->toString()}";
            $response = $this->client->post($url, ['body' => '{}']);
            $body = $this->handleResponse($response, 201);

            return DunningResource::fromJson($body);
        }, "Dunning pursued from voucher (ID: {$id->toString()})");
    }
}
