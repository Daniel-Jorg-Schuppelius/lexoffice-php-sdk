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

use CommonToolkit\Enums\CurrencyCode;
use Lexoffice\Entities\Vouchers\BaseVoucher;
use Lexoffice\Enums\VoucherType;

class Voucher extends BaseVoucher {
    protected VoucherType $voucherType;
    protected float $totalAmount;
    protected float $openAmount;
    protected CurrencyCode $currency;
    protected bool $archived;

    public function getVoucherType(): VoucherType {
        return $this->voucherType;
    }

    public function getTotalAmount(): float {
        return $this->totalAmount;
    }

    public function getOpenAmount(): float {
        return $this->openAmount;
    }

    public function getCurrency(): CurrencyCode {
        return $this->currency;
    }

    public function isArchived(): bool {
        return $this->archived;
    }
}
