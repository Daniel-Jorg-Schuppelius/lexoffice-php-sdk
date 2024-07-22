<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

class ClosingInvoiceID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->name = 'closingInvoiceId';
    }
}
