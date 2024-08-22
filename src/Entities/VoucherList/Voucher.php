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
    public bool $archived;
}
