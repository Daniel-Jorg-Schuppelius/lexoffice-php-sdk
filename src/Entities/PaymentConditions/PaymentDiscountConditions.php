<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PaymentConditions;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class PaymentDiscountConditions extends NamedEntity {
    public float $discountPercentage;
    public int $discountRange;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }
}
