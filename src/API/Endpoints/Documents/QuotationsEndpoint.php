<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : QuotationsEndpoint.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

namespace Lexoffice\API\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use APIToolkit\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\Quotations\Quotation;
use Lexoffice\Entities\Documents\Quotations\QuotationResource;
use APIToolkit\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;
use APIToolkit\Exceptions\NotAllowedException;

class QuotationsEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'quotations';

    public function create(NamedEntityInterface $data, ID $id = null): QuotationResource {
        if (!$data->isValid()) {
            throw new \InvalidArgumentException('Data is not valid');
        }

        $response = $this->client->post($this->getEndpointUrl(), [
            'body' => $data->toJson(),
        ]);
        $body = $this->handleResponse($response, 201);

        return QuotationResource::fromJson($body);
    }

    public function get(?ID $id = null): Quotation {
        if (is_null($id)) {
            throw new \InvalidArgumentException('ID is required');
        }

        return Quotation::fromJson(parent::getContents([], [], "{$this->getEndpointUrl()}/{$id->toString()}"));
    }

    public function pursue(VoucherID $id, bool $finalize = false): QuotationResource {
        throw new NotAllowedException('Quotations cannot be pursued');
    }
}
