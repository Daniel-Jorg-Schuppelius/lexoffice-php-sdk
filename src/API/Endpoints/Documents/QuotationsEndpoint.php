<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : QuotationsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints\Documents;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use APIToolkit\Exceptions\NotAllowedException;
use InvalidArgumentException;
use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Entities\Documents\Quotations\Quotation;
use Lexoffice\Entities\Documents\Quotations\QuotationResource;
use Lexoffice\Entities\Vouchers\VoucherID;

class QuotationsEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'quotations';

    public function create(NamedEntityInterface $data, ?ID $id = null, bool $finalize = false): QuotationResource {
        if (!$data->isValid()) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'Quotation data is not valid');
        }

        self::logDebug('Creating quotation', ['endpoint' => $this->endpoint, 'finalize' => $finalize]);

        return self::logInfoWithTimer(function () use ($data, $finalize) {
            $url = $this->getEndpointUrl();
            if ($finalize) {
                $url .= '?finalize=true';
            }
            $response = $this->client->post($url, [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 201);

            return QuotationResource::fromJson($body);
        }, 'Quotation created');
    }

    public function get(?ID $id = null): Quotation {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a quotation');
        }

        self::logDebug('Fetching quotation', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn() => Quotation::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Quotation fetched (ID: {$id->toString()})"
        );
    }

    public function pursue(VoucherID $id, bool $finalize = false): QuotationResource {
        self::logErrorAndThrow(NotAllowedException::class, 'Quotations cannot be pursued');
    }
}
