<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Files;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class Files extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = File::class;
        parent::__construct($data, $logger);
    }
}