<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PaymentConditions;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class PaymentConditions extends NamedValueList {
    public function __construct($data = null) {
        $this->className = PaymentCondition::class;
        parent::__construct($data);
    }
}
