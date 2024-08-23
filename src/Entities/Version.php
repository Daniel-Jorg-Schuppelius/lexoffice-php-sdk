<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

use Lexoffice\Contracts\Abstracts\NamedValue;
use Psr\Log\LoggerInterface;

class Version extends NamedValue {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
        $this->readOnly = true;
        $this->entityName = 'version';
    }

    public function isValid(): bool {
        return isset($this->value) && is_numeric($this->value) && $this->value >= 0;
    }
}
