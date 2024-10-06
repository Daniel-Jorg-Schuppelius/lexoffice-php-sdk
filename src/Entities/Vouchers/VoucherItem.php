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
use Psr\Log\LoggerInterface;

class VoucherItem extends NamedEntity {
    protected float $amount;
    protected float $taxAmount;
    protected float $taxRatePercent;
    protected CategoryID $categoryId;

    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getTaxAmount(): float {
        return $this->taxAmount;
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
