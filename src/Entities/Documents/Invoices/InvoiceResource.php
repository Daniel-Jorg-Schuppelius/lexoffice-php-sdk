<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Invoices;

use Lexoffice\Contracts\Abstracts\ResourceAbstract;
use Lexoffice\Contracts\Interfaces\NamedEntityInterface;

class InvoiceResource extends ResourceAbstract {
    public function getResource(): NamedEntityInterface {
        return new Invoice();
    }
}
