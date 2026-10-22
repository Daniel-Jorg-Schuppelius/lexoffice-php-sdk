<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DownPaymentInvoicesEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\API\Endpoints\Documents;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Entities\ID;
use InvalidArgumentException;
use Lexoffice\Contracts\Traits\FileDownloadTrait;
use Lexoffice\Entities\Documents\DownPaymentInvoices\DownPaymentInvoice;
use Lexoffice\Entities\Files\FileContent;

class DownPaymentInvoicesEndpoint extends EndpointAbstract {
    use FileDownloadTrait;

    protected string $endpoint = 'down-payment-invoices';

    public function get(?ID $id = null): DownPaymentInvoice {
        if (is_null($id)) {
            self::logErrorAndThrow(InvalidArgumentException::class, 'ID is required for getting a down payment invoice');
        }

        self::logDebug('Fetching down payment invoice', ['id' => $id->toString()]);

        return self::logDebugWithTimer(
            fn () => DownPaymentInvoice::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}")),
            "Down payment invoice fetched (ID: {$id->toString()})"
        );
    }

    /**
     * Belegdatei über `GET /down-payment-invoices/{id}/file`.
     */
    public function downloadContent(ID $id, string $accept = '*/*'): FileContent {
        return $this->fetchFileContent("{$this->getEndpointUrl()}/{$id->toString()}/file", $accept);
    }
}
