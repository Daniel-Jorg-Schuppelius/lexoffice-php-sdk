<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PaymentConditions;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class PaymentDiscountConditions extends NamedEntity {
    public float $discountPercentage;
    public int $discountRange;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
