<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document;

use Lexoffice\Entities\ID;

class PrintLayoutID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->name = 'printLayoutId';
    }
}
