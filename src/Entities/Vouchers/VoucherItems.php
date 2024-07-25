<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use Lexoffice\Contracts\Abstracts\NamedValueList;

class VoucherItems extends NamedValueList {
    public function __construct($data = null) {
        $this->className = VoucherItem::class;
        parent::__construct($data);
    }
}
