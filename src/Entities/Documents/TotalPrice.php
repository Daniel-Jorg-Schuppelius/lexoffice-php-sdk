<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\Currency;
use Psr\Log\LoggerInterface;

class TotalPrice extends NamedEntity {
    protected Currency $currency;
    protected ?float $totalNetAmount;
    protected ?float $totalGrossAmount;
    protected ?float $totalTaxAmount;
    protected ?float $totalDiscountAbsolute;
    protected ?float $totalDiscountPercentage;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getCurrency(): Currency {
        return $this->currency;
    }

    public function getTotalNetAmount(): ?float {
        return $this->totalNetAmount;
    }

    public function getTotalGrossAmount(): ?float {
        return $this->totalGrossAmount;
    }

    public function getTotalTaxAmount(): ?float {
        return $this->totalTaxAmount;
    }

    public function getTotalDiscountAbsolute(): ?float {
        return $this->totalDiscountAbsolute;
    }

    public function getTotalDiscountPercentage(): ?float {
        return $this->totalDiscountPercentage;
    }

    public function setCurrency(Currency $currency): void {
        $this->currency = $currency;
    }
}
