<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : UnitPrice.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use CommonToolkit\Enums\CurrencyCode;
use Psr\Log\LoggerInterface;

class UnitPrice extends NamedEntity {
    protected CurrencyCode $currency;
    protected ?float $netAmount;
    protected ?float $grossAmount;
    protected float $taxRatePercentage;

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

    public function getCurrency(): CurrencyCode {
        return $this->currency;
    }

    public function getNetAmount(): ?float {
        return $this->netAmount;
    }

    public function getGrossAmount(): ?float {
        return $this->grossAmount;
    }

    public function getTaxRatePercentage(): float {
        return $this->taxRatePercentage;
    }

    public function setCurrency(CurrencyCode $currency): void {
        $this->currency = $currency;
    }

    public function setNetAmount(float $netAmount): void {
        $this->netAmount = $netAmount;
    }

    public function setGrossAmount(float $grossAmount): void {
        $this->grossAmount = $grossAmount;
    }

    public function setTaxRatePercentage(float $taxRatePercentage): void {
        $this->taxRatePercentage = $taxRatePercentage;
    }
}
