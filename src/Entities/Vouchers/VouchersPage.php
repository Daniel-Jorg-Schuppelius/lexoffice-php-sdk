<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Articles;

use Lexoffice\Contracts\Abstracts\NamedPage;
use Lexoffice\Entities\VoucherList\Vouchers;

class VouchersPage extends NamedPage {
    public function __construct($data = null) {
        $this->className = Vouchers::class;
        parent::__construct($data);
    }
}
