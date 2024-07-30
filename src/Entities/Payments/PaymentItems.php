<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Payments;

use Lexoffice\Contracts\Abstracts\NamedValues;

class PaymentItems extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = PaymentItem::class;
        parent::__construct($data);
    }
}
