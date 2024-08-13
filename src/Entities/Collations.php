<?php

declare(strict_types=1);

namespace Lexoffice\Entities;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Lexoffice\Entities\Sort;
use Psr\Log\LoggerInterface;

class Collations extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = Sort::class;
        parent::__construct($data, $logger);
    }
}
