<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Payments;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class Payments extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->valueClassName = Payment::class;
        parent::__construct($data, $logger);
    }
}
