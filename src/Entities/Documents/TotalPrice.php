<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : TotalPrice.php
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

class TotalPrice extends NamedEntity {
    use MoneyAccessorTrait;

    protected CurrencyCode $currency;
    protected ?float $totalNetAmount;
    protected ?float $totalGrossAmount;
    protected ?float $totalTaxAmount;
    protected ?float $totalDiscountAbsolute;
    protected ?float $totalDiscountPercentage;

    /**
     * @param array<string, mixed>|object|null $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getCurrency(): CurrencyCode {
        return $this->currency;
    }

    public function getTotalNetAmount(): ?Money {
        return $this->toMoney($this->totalNetAmount);
    }

    public function getTotalGrossAmount(): ?Money {
        return $this->toMoney($this->totalGrossAmount);
    }

    public function getTotalTaxAmount(): ?Money {
        return $this->toMoney($this->totalTaxAmount);
    }

    /**
     * Absoluter Rabattbetrag — Geld, daher Money. Der prozentuale Rabatt
     * darunter bleibt bewusst float.
     */
    public function getTotalDiscountAbsolute(): ?Money {
        return $this->toMoney($this->totalDiscountAbsolute);
    }

    public function getTotalDiscountPercentage(): ?float {
        return $this->totalDiscountPercentage;
    }

    public function setCurrency(CurrencyCode $currency): void {
        $this->currency = $currency;
    }
}
