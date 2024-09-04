<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Psr\Log\LoggerInterface;

class ExtendedLineItem extends LineItem {
    protected ?float $discountPercentage;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getDiscountPercentage(): ?float {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(?float $discountPercentage): void {
        $this->discountPercentage = $discountPercentage;
    }
}
