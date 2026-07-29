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
     * Default 0.0: Die API liefert den Steuersatz nicht in jeder Antwort mit
     * (Teilobjekte, steuerfreie Positionen). Ohne Vorbelegung griffe die
     * Ableitung unten auf eine uninitialisierte typisierte Property zu und
     * würde einen Error werfen.
     */
    protected float $taxRatePercentage = 0.0;

    /**
     * @param array<string, mixed>|object|null $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);

        // Ableitung über Money statt float-Arithmetik: gleiche Rechenweise und
        // Rundung wie beim Lesen (MoneyAccessorTrait), damit netto/brutto auch
        // bei krummen Sätzen konsistent zueinander bleiben.
        if (!isset($this->netAmount) && isset($this->grossAmount)) {
            $this->netAmount = $this->toMoney($this->grossAmount)
                ?->dividedBy(1 + $this->taxRatePercentage / 100)
                ->toFloat();
        } elseif (!isset($this->grossAmount) && isset($this->netAmount)) {
            $this->grossAmount = $this->toMoney($this->netAmount)
                ?->plusPercentage($this->taxRatePercentage)
                ->toFloat();
        } elseif (!isset($this->netAmount) && !isset($this->grossAmount)) {
            $this->netAmount = 0;
            $this->grossAmount = 0;
        }
    }

    /**
     * Belegwährung; ohne eigenes Feld gilt wie im MoneyAccessorTrait der Euro.
     */
    public function getCurrency(): CurrencyCode {
        return $this->entityCurrency();
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
