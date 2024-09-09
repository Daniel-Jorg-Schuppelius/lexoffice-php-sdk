<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\Invoices;

use APIToolkit\Entities\ID;
use Psr\Log\LoggerInterface;

class RecurringTemplateID extends ID {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        parent::__construct($data, $logger);
        $this->entityName = 'recurringTemplateId';
    }
}
