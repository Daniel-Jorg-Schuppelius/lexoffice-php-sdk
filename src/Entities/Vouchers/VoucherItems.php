<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use Lexoffice\Contracts\Abstracts\NamedValues;

class VoucherItems extends NamedValues {
    public function __construct($data = null) {
        $this->valueClassName = VoucherItem::class;
        parent::__construct($data);
    }
}
