<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents;

class PrintLayoutID extends \Lexoffice\Entities\PrintLayouts\PrintLayoutID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->entityName = 'printLayoutId';
    }
}
