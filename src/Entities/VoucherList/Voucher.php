<?php
/*
 * Created on   : Sun Oct 06 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : Voucher.php
 * License      : MIT License
 * License Uri  : https://opensource.org/license/mit
 */

declare(strict_types=1);

namespace Lexoffice\Entities\VoucherList;

use APIToolkit\Traits\MoneyAccessorTrait;
use CommonToolkit\Enums\CurrencyCode;
use CommonToolkit\ValueObjects\Money;
use Lexoffice\Entities\Vouchers\BaseVoucher;
use Lexoffice\Enums\VoucherType;

class Voucher extends BaseVoucher {
    use MoneyAccessorTrait;

    /** Unbekannte (neue) Arten werden null, statt die Seite scheitern zu lassen. */
    protected ?VoucherType $voucherType;
    protected float $totalAmount;
    /** Laut API null u. a. bei Entwürfen und Belegen ohne Zahlung. */
    protected ?float $openAmount;
    protected CurrencyCode $currency;
    protected bool $archived;

    public function getVoucherType(): ?VoucherType {
        return $this->voucherType ?? null;
    }

    public function getTotalAmount(): Money {
        return $this->toMoney($this->totalAmount) ?? Money::zero($this->entityCurrency());
    }

    public function getOpenAmount(): Money {
        return $this->toMoney($this->openAmount ?? null) ?? Money::zero($this->entityCurrency());
    }

    public function getCurrency(): CurrencyCode {
        return $this->currency;
    }

    public function isArchived(): bool {
        return $this->archived;
    }
}
