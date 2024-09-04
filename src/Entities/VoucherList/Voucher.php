<?php

declare(strict_types=1);

namespace Lexoffice\Entities\VoucherList;

use Lexoffice\Entities\Vouchers\BaseVoucher;
use Lexoffice\Enums\Currency;
use Lexoffice\Enums\VoucherType;

class Voucher extends BaseVoucher {
    protected VoucherType $voucherType;
    protected float $totalAmount;
    protected float $openAmount;
    protected Currency $currency;
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

    public function getCurrency(): Currency {
        return $this->currency;
    }

    public function isArchived(): bool {
        return $this->archived;
    }
}
