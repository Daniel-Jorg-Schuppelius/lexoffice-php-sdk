<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DownPaymentInvoices;

use Lexoffice\Contracts\Abstracts\API\ResourceAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

class DownPaymentInvoiceResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new DownPaymentInvoice();
    }
}
