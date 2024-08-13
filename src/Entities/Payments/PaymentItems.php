<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Payments;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class PaymentItems extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = PaymentItem::class;
        parent::__construct($data, $logger);
    }
}
