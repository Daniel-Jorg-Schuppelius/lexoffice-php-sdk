<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use Lexoffice\Contracts\Abstracts\NamedPage;
use Lexoffice\Entities\Vouchers\Vouchers;
use Psr\Log\LoggerInterface;

class VouchersPage extends NamedPage {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = Vouchers::class;
        parent::__construct($data, $logger);
    }
}
