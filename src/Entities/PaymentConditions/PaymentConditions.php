<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PaymentConditions;

use Lexoffice\Contracts\Abstracts\NamedValues;

class PaymentConditions extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = PaymentCondition::class;
        parent::__construct($data);
    }
}
