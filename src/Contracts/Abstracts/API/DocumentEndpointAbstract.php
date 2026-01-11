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
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\Vouchers\VoucherID;

abstract class DocumentEndpointAbstract extends EndpointAbstract implements DocumentEndpointInterface {
    abstract public function create(NamedEntityInterface $data, ?ID $id = null, bool $finalize = false): ResourceNamedEntityInterface;
    abstract public function get(?ID $id = null): NamedEntityInterface;
    abstract public function pursue(VoucherID $id, bool $finalize = false): ResourceNamedEntityInterface;

    public function render(ID $id): DocumentFileID {
        self::logDebug('Rendering document', ['id' => $id->toString(), 'endpoint' => $this->endpoint]);

        return self::logInfoWithTimer(function () use ($id) {
            $response = $this->client->get("{$this->getEndpointUrl()}/{$id->toString()}/document");
            $body = $this->handleResponse($response, 200);

            return DocumentFileID::fromJson($body);
        }, "Document rendered (ID: {$id->toString()})");
    }
}
