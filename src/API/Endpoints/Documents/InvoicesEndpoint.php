<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : InvoicesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints\Documents;

use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Entities\Documents\Invoices\Invoice;
use Lexoffice\Entities\Documents\Invoices\InvoiceResource;
use Lexoffice\Entities\Vouchers\VoucherID;

class InvoicesEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'invoices';

    public function create(NamedEntityInterface $data, ?ID $id = null, bool $finalize = false): InvoiceResource {
        if (!$data->isValid()) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'Invoice data is not valid');
        }

        self::logDebug('Creating invoice', ['endpoint' => $this->endpoint, 'finalize' => $finalize]);

        return self::logInfoWithTimer(function () use ($data, $finalize) {
            $url = $this->getEndpointUrl();
            if ($finalize) {
                $url .= '?finalize=true';
            }
            $response = $this->client->post($url, [
                'body' => $data->toJson(),
            ]);
            $body = $this->handleResponse($response, 201);

            return InvoiceResource::fromJson($body);
        }, 'Invoice created');
    }

    public function get(?ID $id = null): Invoice {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting an invoice');
        }

        self::logDebug('Fetching invoice', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn() => Invoice::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Invoice fetched (ID: {$id->toString()})"
        );
    }

    public function pursue(VoucherID $id, bool $finalize = false): InvoiceResource {
        self::logDebug('Pursuing invoice from voucher', ['voucherId' => $id->toString(), 'finalize' => $finalize]);

        return self::logInfoWithTimer(function () use ($id, $finalize) {
            $url = "{$this->getEndpointUrl()}?precedingSalesVoucherId={$id->toString()}";
            if ($finalize) {
                $url .= '&finalize=true';
            }
            $response = $this->client->post($url, ['body' => '{}']);
            $body = $this->handleResponse($response, 201);

            return InvoiceResource::fromJson($body);
        }, "Invoice pursued from voucher (ID: {$id->toString()})");
    }
}
