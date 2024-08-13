<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use Lexoffice\Entities\ID;
use Psr\Log\LoggerInterface;

class CategoryID extends ID {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
        $this->entityName = 'categoryId';
    }
}
