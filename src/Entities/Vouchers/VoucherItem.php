<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : VoucherItem.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use APIToolkit\Contracts\Abstracts\NamedEntity;
use CommonToolkit\ValueObjects\Money;
use Lexoffice\Traits\MoneyAccessorTrait;
use Psr\Log\LoggerInterface;

class VoucherItem extends NamedEntity {
    use MoneyAccessorTrait;

    protected float $amount;
    protected float $taxAmount;
    protected float $taxRatePercent;
    protected CategoryID $categoryId;

    /**
     * @param array<string, mixed>|object|null $data
     */
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getAmount(): Money {
        return $this->toMoney($this->amount) ?? Money::zero($this->entityCurrency());
    }

    public function getTaxAmount(): Money {
        return $this->toMoney($this->taxAmount) ?? Money::zero($this->entityCurrency());
    }

    public function getTaxRatePercent(): float {
        return $this->taxRatePercent;
    }

    public function getCategoryId(): CategoryID {
        return $this->categoryId;
    }

    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }

    public function setTaxAmount(float $taxAmount): void {
        $this->taxAmount = $taxAmount;
    }

    public function setTaxRatePercent(float $taxRatePercent): void {
        $this->taxRatePercent = $taxRatePercent;
    }

    public function setCategoryId(CategoryID $categoryId): void {
        $this->categoryId = $categoryId;
    }
}
