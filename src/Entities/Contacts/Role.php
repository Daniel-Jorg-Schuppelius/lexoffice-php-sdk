<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValue;

class Role extends NamedValue {
    public function __construct($data = null) {
        $this->entityName = 'number';
        parent::__construct($data);
    }

    public function toArray(): array {
        if (is_null($this->value)) {
            return [];
        }
        return [
            $this->entityName => $this->value
        ];
    }
}
