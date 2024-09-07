<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class VoucherItems extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = VoucherItem::class;
        parent::__construct($data, $logger);
    }
}
