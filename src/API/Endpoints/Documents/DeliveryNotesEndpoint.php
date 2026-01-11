<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DeliveryNotesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints\Documents;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNote;
use Lexoffice\Entities\Documents\DeliveryNotes\DeliveryNoteResource;
use Lexoffice\Entities\Vouchers\VoucherID;

class DeliveryNotesEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'delivery-notes';

    public function create(NamedEntityInterface $data, ?ID $id = null, bool $finalize = false): DeliveryNoteResource {
        self::logDebug('Creating delivery note', ['endpoint' => $this->endpoint, 'finalize' => $finalize]);

        return self::logInfoWithTimer(function () use ($data, $finalize) {
            $url = $this->getEndpointUrl();
            if ($finalize) {
                $url .= '?finalize=true';
            }
            $response = $this->client->post($url, [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 201);

            return DeliveryNoteResource::fromJson($body);
        }, 'Delivery note created');
    }

    public function get(?ID $id = null): DeliveryNote {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a delivery note');
        }

        self::logDebug('Fetching delivery note', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn() => DeliveryNote::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Delivery note fetched (ID: {$id->toString()})"
        );
    }

    public function pursue(VoucherID $id, bool $finalize = false): DeliveryNoteResource {
        self::logDebug('Pursuing delivery note from voucher', ['voucherId' => $id->toString()]);

        return self::logInfoWithTimer(function () use ($id) {
            $url = "{$this->getEndpointUrl()}?precedingSalesVoucherId={$id->toString()}";
            $response = $this->client->post($url, ['body' => '{}']);
            $body = $this->handleResponse($response, 201);

            return DeliveryNoteResource::fromJson($body);
        }, "Delivery note pursued from voucher (ID: {$id->toString()})");
    }

    public function sendMail(ID $id, array $recipients, ?string $message = null, ?string $signature = null, array $attachments = []): void {
        self::logDebug('Sending delivery note via email', ['id' => $id->toString(), 'recipients' => $recipients]);

        self::logInfoWithTimer(function () use ($id, $recipients, $message, $signature, $attachments) {
            $payload = ['recipients' => $recipients];
            if ($message !== null) {
                $payload['message'] = $message;
            }
            if ($signature !== null) {
                $payload['signature'] = $signature;
            }
            if (!empty($attachments)) {
                $payload['attachments'] = $attachments;
            }

            $response = $this->client->post("{$this->getEndpointUrl()}/{$id->toString()}/sendmail", [
                'body' => json_encode($payload),
            ]);
            $this->handleResponse($response, 204);
        }, "Delivery note sent via email (ID: {$id->toString()})");
    }
}
