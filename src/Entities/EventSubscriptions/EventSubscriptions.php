<?php

declare(strict_types=1);

namespace Lexoffice\Entities\EventSubscriptions;

use Lexoffice\Contracts\Abstracts\NamedValues;
use Psr\Log\LoggerInterface;

class EventSubscriptions extends NamedValues {
    public function __construct($data = null, ?LoggerInterface $logger = null) {
        $this->entityName = "content";
        $this->valueClassName = EventSubscription::class;

        parent::__construct($data, $logger);
    }
}
