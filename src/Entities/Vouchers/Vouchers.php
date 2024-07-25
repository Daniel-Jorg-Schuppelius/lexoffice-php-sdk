<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use Lexoffice\Contracts\Abstracts\NamedValueList;
use Lexoffice\Entities\Vouchers\Voucher;

class Vouchers extends NamedValueList {
    public function __construct($data = null) {
        $this->entityName = "content";
        $this->className = Voucher::class;

        parent::__construct($data);
    }
}
