<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : DocumentEndpointAbstract.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Contracts\Abstracts\API;

use APIToolkit\Contracts\Abstracts\API\EndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use APIToolkit\Entities\ID;
use Lexoffice\Contracts\Interfaces\API\DocumentEndpointInterface;
use Lexoffice\Contracts\Interfaces\ResourceNamedEntityInterface;
use Lexoffice\Contracts\Traits\FileDownloadTrait;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\Files\FileContent;
use Lexoffice\Entities\Vouchers\VoucherID;

abstract class DocumentEndpointAbstract extends EndpointAbstract implements DocumentEndpointInterface {
    use FileDownloadTrait;

    /**
     * @param ID|null $id Vorgängerbeleg (`precedingSalesVoucherId`), z. B. das
     *                    Angebot einer Rechnung; ohne Angabe ein freier Beleg.
     */
    abstract public function create(NamedEntityInterface $data, ?ID $id = null, bool $finalize = false): ResourceNamedEntityInterface;
    abstract public function get(?ID $id = null): NamedEntityInterface;

    /**
     * Beleg aus einem Vorgänger fortführen. Lexware erwartet den vollständigen
     * Beleg im Body; mit `$data` entspricht der Aufruf `create($data, $id, $finalize)`.
     */
    abstract public function pursue(VoucherID $id, bool $finalize = false, ?NamedEntityInterface $data = null): ResourceNamedEntityInterface;

    /**
     * @deprecated Lexware führt `/{id}/document` als veraltet; {@see downloadContent()} lädt die Datei direkt.
     */
    public function render(ID $id): DocumentFileID {
        self::logDebug('Rendering document', ['id' => $id->toString(), 'endpoint' => $this->endpoint]);

        return self::logInfoWithTimer(function () use ($id) {
            $response = $this->client->get("{$this->getEndpointUrl()}/{$id->toString()}/document");
            $body = $this->handleResponse($response, 200);

            return DocumentFileID::fromJson($body);
        }, "Document rendered (ID: {$id->toString()})");
    }

    /**
     * Belegdatei über `GET /{beleg}/{id}/file`. Für eine XRechnung liefert
     * `application/xml` das XML und `application/pdf` die Vorschau; ein Entwurf
     * hat keine Datei (409).
     */
    public function downloadContent(ID $id, string $accept = '*/*'): FileContent {
        return $this->fetchFileContent("{$this->getEndpointUrl()}/{$id->toString()}/file", $accept);
    }

    /**
     * POST-Ziel für Anlegen und Fortführen; `finalize` nur, wenn gewünscht.
     */
    protected function createUrl(?ID $precedingSalesVoucherId, bool $finalize): string {
        $query = [];
        if ($precedingSalesVoucherId !== null) {
            $query['precedingSalesVoucherId'] = $precedingSalesVoucherId->toString();
        }
        if ($finalize) {
            $query['finalize'] = 'true';
        }

        return $query === [] ? $this->getEndpointUrl() : $this->getEndpointUrl() . '?' . http_build_query($query);
    }
}
