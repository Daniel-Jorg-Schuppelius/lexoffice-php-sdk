<?php

declare(strict_types=1);

namespace Lexoffice\Entities\PrintLayouts;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class PrintLayouts extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = PrintLayout::class;
        parent::__construct($data, $logger);
    }
}
