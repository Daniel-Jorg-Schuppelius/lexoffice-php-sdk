<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Invoices;

use Lexoffice\Contracts\Abstracts\NamedValues;

class DownPaymentDeductions extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = DownPaymentDeduction::class;
        parent::__construct($data);
    }
}
