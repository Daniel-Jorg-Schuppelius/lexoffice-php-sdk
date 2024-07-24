<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Profile;

use Lexoffice\Entities\ID;

class UserID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->entityName = 'userId';
    }
}
