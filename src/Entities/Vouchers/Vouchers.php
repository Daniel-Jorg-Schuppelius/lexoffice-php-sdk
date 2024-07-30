<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Lexoffice\Entities\Vouchers\Voucher;

class Vouchers extends NamedValues {
    public function __construct($data = null) {
        $this->entityName = "content";
        $this->valueClassName = Voucher::class;

        parent::__construct($data);
    }
}
