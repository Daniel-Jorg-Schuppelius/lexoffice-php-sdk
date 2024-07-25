<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use Lexoffice\Contracts\Abstracts\NamedEntity;

class VoucherItem extends NamedEntity {
    public float $amount;
    public float $taxAmount;
    public float $taxRatePercent;
    public CategoryID $categoryId;

    public function __construct($data = null) {
        parent::__construct($data);
    }
}
