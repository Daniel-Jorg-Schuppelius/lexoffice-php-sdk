<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contact;

use Lexoffice\Contracts\Abstracts\NamedValue;

class Role extends NamedValue {
    public function __construct($data = null) {
        $this->entityName = 'number';
        parent::__construct($data);
    }
}
