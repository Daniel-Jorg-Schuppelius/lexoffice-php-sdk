<?php

declare(strict_types=1);

namespace Lexoffice\Entities\Documents\RecurringTemplates;

use APIToolkit\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class RecurringTemplates extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = "content";
        $this->valueClassName = RecurringTemplate::class;

        parent::__construct($data, $logger);
    }
}
