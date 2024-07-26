<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Vouchers;

use Lexoffice\Entities\ID;

class CategoryID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->entityName = 'categoryId';
    }
}