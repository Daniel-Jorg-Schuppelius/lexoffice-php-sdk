<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Document\Invoices;

use Lexoffice\Entities\ID;

class RecurringTemplateID extends ID {
    public function __construct($data = null) {
        parent::__construct($data);
        $this->entityName = 'recurringTemplateId';
    }
}
