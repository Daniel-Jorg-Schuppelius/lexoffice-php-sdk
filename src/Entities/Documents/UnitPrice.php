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
use APIToolkit\Traits\MoneyAccessorTrait;
use CommonToolkit\Enums\CurrencyCode;
use CommonToolkit\ValueObjects\Money;
use Psr\Log\LoggerInterface;

class UnitPrice extends NamedEntity {
    use MoneyAccessorTrait;

    protected CurrencyCode $currency;
    protected ?float $netAmount;
    protected ?float $grossAmount;

    /**
     * Pflichtfeld laut API, ohne Vorgabe: ein fehlender Satz ginge sonst als
     * 0 % hinaus.
     */
    protected float $taxRatePercentage;

    /**
     * @param array<string, mixed>|object|null $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    /**
     * Belegwährung; ohne eigenes Feld gilt wie im MoneyAccessorTrait der Euro.
     */
    public function getCurrency(): CurrencyCode {
        return $this->entityCurrency();
    }

    /**
     * Netto wie geliefert; fehlt er, aus Brutto und Steuersatz abgeleitet.
     * Die Ableitung gilt nur beim Lesen — gesendet wird, was gesetzt ist:
     * Lexware liest je nach taxType genau einen der beiden Beträge.
     */
    public function getNetAmount(): ?Money {
        if (isset($this->netAmount)) {
            return $this->toMoney($this->netAmount);
        }
        if (!isset($this->grossAmount, $this->taxRatePercentage)) {
            return null;
        }

        return $this->toMoney($this->grossAmount)?->dividedBy(1 + $this->taxRatePercentage / 100);
    }

    /**
     * Brutto wie geliefert; fehlt er, aus Netto und Steuersatz abgeleitet.
     */
    public function getGrossAmount(): ?Money {
        if (isset($this->grossAmount)) {
            return $this->toMoney($this->grossAmount);
        }
        if (!isset($this->netAmount, $this->taxRatePercentage)) {
            return null;
        }

        return $this->toMoney($this->netAmount)?->plusPercentage($this->taxRatePercentage);
    }

    public function getTaxRatePercentage(): ?float {
        return $this->taxRatePercentage ?? null;
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
