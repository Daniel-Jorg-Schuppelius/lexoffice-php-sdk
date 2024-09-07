<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PaymentConditions;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use Psr\Log\LoggerInterface;

class PaymentDiscountConditions extends NamedEntity {
    protected float $discountPercentage;
    protected int $discountRange;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getDiscountPercentage(): float {
        return $this->discountPercentage;
    }

    public function getDiscountRange(): int {
        return $this->discountRange;
    }

    public function setDiscountPercentage(float $discountPercentage): void {
        $this->discountPercentage = $discountPercentage;
    }

    public function setDiscountRange(int $discountRange): void {
        $this->discountRange = $discountRange;
    }
}
