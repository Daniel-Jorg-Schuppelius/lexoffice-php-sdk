<?php

namespace Lexoffice\Api\Endpoints\Documents;

use Lexoffice\Contracts\Abstracts\API\DocumentEndpointAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;
use Lexoffice\Entities\Documents\DownPaymentInvoices\DownPaymentInvoice;
use Lexoffice\Entities\Documents\DownPaymentInvoices\DownPaymentInvoiceResource;
use Lexoffice\Entities\Documents\DocumentFileID;
use Lexoffice\Entities\ID;
use Lexoffice\Entities\Vouchers\VoucherID;
use Lexoffice\Exceptions\NotAllowedException;

class DownPaymentInvoicesEndpoint extends DocumentEndpointAbstract {
    protected string $endpoint = 'down-payment-invoices';

    public function create(NamedEntityInterface $data, ID $id = null): DownPaymentInvoiceResource {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function get(ID $id): DownPaymentInvoice {
        $response = $this->client->get("{$this->endpoint}/{$id->toString()}");
        $body = $this->handleResponse($response, 200);

        return DownPaymentInvoice::fromJson($body);
    }

    public function update(ID $id, NamedEntityInterface $data): DownPaymentInvoiceResource {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function delete(ID $id): bool {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function render(ID $id): DocumentFileID {
        throw new NotAllowedException('Not Allowed', 405);
    }

    public function pursue(VoucherID $id, bool $finalize = false): DownPaymentInvoiceResource {
        throw new NotAllowedException('Not Allowed', 405);
    }
}
