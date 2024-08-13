<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Invoices;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class DownPaymentDeductions extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = DownPaymentDeduction::class;
        parent::__construct($data, $logger);
    }
}
