<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use Lexoffice\Entities\ID;

class FileID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->entityName = 'id';
    }
}
