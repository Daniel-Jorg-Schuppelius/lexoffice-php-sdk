<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Invoices;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class DownPaymentDeductions extends NamedValueList {
    public function __construct($data = null) {
        $this->className = DownPaymentDeduction::class;
        parent::__construct($data);
    }
}
