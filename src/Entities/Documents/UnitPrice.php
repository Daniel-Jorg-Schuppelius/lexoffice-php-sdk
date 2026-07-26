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
use CommonToolkit\ValueObjects\Money;
use Lexoffice\Traits\MoneyAccessorTrait;
use Psr\Log\LoggerInterface;

class UnitPrice extends NamedEntity {
    use MoneyAccessorTrait;

    protected CurrencyCode $currency;
    protected ?float $netAmount;
    protected ?float $grossAmount;
    protected float $taxRatePercentage;

    /**
     * @param array<string, mixed>|object|null $data
     */
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

    public function getNetAmount(): ?Money {
        return $this->toMoney($this->netAmount);
    }

    public function getGrossAmount(): ?Money {
        return $this->toMoney($this->grossAmount);
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
