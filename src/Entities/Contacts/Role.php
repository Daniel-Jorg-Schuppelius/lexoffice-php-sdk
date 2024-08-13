<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Contacts;

use Lexoffice\Contracts\Abstracts\NamedValue;
use Psr\Log\LoggerInterface;

class Role extends NamedValue {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = 'number';
        parent::__construct($data, $logger);
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
