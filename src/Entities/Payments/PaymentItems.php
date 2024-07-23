<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Payments;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class PaymentItems extends NamedValueList {
    public function __construct($data = null) {
        $this->className = PaymentItem::class;
        parent::__construct($data);
    }
}
