<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Lexoffice\Entities\Vouchers\Voucher;
use Psr\Log\LoggerInterface;

class Vouchers extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = "content";
        $this->valueClassName = Voucher::class;

        parent::__construct($data, $logger);
    }
}
