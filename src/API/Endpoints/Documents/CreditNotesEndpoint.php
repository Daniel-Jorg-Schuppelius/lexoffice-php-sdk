<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : CreditNotesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints\Documents;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Entities\Documents\CreditNotes\{CreditNote, CreditNoteResource};
use Lexoffice\Entities\Vouchers\VoucherID;

class CreditNotesEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'credit-notes';

    public function create(NamedEntityInterface $data, ?ID $id = null, bool $finalize = false): CreditNoteResource {
        if (!$data->isValid()) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'Credit note data is not valid');
        }

        self::logDebug('Creating credit note', ['endpoint' => $this->endpoint, 'finalize' => $finalize]);

        return self::logInfoWithTimer(function () use ($data, $finalize) {
            $url = $this->getEndpointUrl();
            if ($finalize) {
                $url .= '?finalize=true';
            }
            $response = $this->client->post($url, [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 201);

            return CreditNoteResource::fromJson($body);
        }, 'Credit note created');
    }

    public function get(?ID $id = null): CreditNote {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a credit note');
        }

        self::logDebug('Fetching credit note', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn () => CreditNote::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Credit note fetched (ID: {$id->toString()})"
        );
    }

    public function pursue(VoucherID $id, bool $finalize = false): CreditNoteResource {
        self::logDebug('Pursuing credit note from voucher', ['voucherId' => $id->toString(), 'finalize' => $finalize]);

        return self::logInfoWithTimer(function () use ($id, $finalize) {
            $url = "{$this->getEndpointUrl()}?precedingSalesVoucherId={$id->toString()}";
            if ($finalize) {
                $url .= '&finalize=true';
            }
            $response = $this->client->post($url, ['body' => '{}']);
            $body = $this->handleResponse($response, 201);

            return CreditNoteResource::fromJson($body);
        }, "Credit note pursued from voucher (ID: {$id->toString()})");
    }
}
