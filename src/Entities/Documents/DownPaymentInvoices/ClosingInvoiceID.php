<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\DownPaymentInvoices;

use Lexoffice\Entities\ID;

class ClosingInvoiceID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->entityName = 'closingInvoiceId';
    }
}
