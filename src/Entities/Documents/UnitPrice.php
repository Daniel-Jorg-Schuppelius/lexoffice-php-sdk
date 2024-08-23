<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use Lexoffice\Contracts\Abstracts\NamedEntity;
use Lexoffice\Enums\Currency;
use Psr\Log\LoggerInterface;

class UnitPrice extends NamedEntity {
    public Currency $currency;
    public ?float $netAmount;
    public ?float $grossAmount;
    public float $taxRatePercentage;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);

        if (!isset($this->netAmount) && isset($this->grossAmount)) {
            $this->netAmount = $this->grossAmount / (1 + $this->taxRatePercentage / 100);
        } elseif (!isset($this->grossAmount) && isset($this->netAmount)) {
            $this->grossAmount = $this->netAmount * (1 + $this->taxRatePercentage / 100);
        } elseif (!isset($this->netAmount) && !isset($this->grossAmount)) {
            $this->netAmount = 0;
            $this->grossAmount = 0;
        }
    }
}
