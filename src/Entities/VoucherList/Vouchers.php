<?php

declare(strict_types=1);

namespace Lexoffice\Entities\VoucherList;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Lexoffice\Entities\VoucherList\Voucher;
use Psr\Log\LoggerInterface;

class Vouchers extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = "content";
        $this->valueClassName = Voucher::class;

        parent::__construct($data, $logger);
    }
}
